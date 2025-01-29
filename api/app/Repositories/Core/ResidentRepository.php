<?php

namespace App\Repositories\Core;
use App\Models\ResidentAnimals;
use App\Models\DriveResident;
use App\Models\ResidentEmployee;
use App\Models\Resident;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserProfile;
use App\Models\Animals;
use App\Models\Employee;
use App\Models\Drive;
use App\Models\Apartment;
use App\Exceptions\CredentialsException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResidentRepository extends BaseRepository
{
    private $modalUser;
    public function __construct(private readonly Resident $resident) {
        parent::__construct($resident);
        $this->modalUser = new User();
    }
    public function getAll(): Collection
    {
        return $this->relationship($this->resident)->get();
    }
    public function getUserByEmail(string $email)
    {
        $user = $this->modalUser->where('email', $email)->first();
        return ($user ? $user : null) ;
    }
    
    public function getUserById(int $id) {
        $user = $this->modalUser->where('id', $id)->first();
        return ($user ? $user : null) ;
    }

    public function findById(int $id): object
    {
        return $this->relationship($this->resident)->findOrFail($id);
    }

    public function formatNumber(string $number) {
        $number = preg_replace('/[^0-9]/', '', $number);
        return $number;
    }

    /**
     * Summary of update
     * @param object $entity
     * @param array $data
     * @throws \App\Exceptions\CredentialsException
     * @return void
     */
    public function update(object $entity, array $data): void
    {
        try {
            DB::beginTransaction();
            $entity->update($data['resident']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw new CredentialsException($th->getMessage());
        }
    }

    /**
     * @param array $data
     * @return void
     * @throws CredentialsException
     *
     * Cadastrar dados que devem ser passados, profile, status, animais, torre/ap, condominio, empregada
     */
    public function store(array $data): void
    {
       
        try {
            DB::beginTransaction();

            $user = ['name' => $data['resident']['name'], 'email' => $data['resident']['email'], 'password' => Hash::make(Str::random(10))];

            $usu = $this->modalUser->create($user);

            $profile = isset($data['profile_id']) ? $data['profile_id'] : $this->profile();            
           
            $this->userProfile($usu->id, $profile);                
            
            $data['resident']['user_id'] = $usu->id;
            $resident = $this->resident->create($data['resident']);    
            
            $data['resident_id'] = $resident->id;
            
            $this->createAssociate($data);            
            
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            throw new CredentialsException($th->getMessage());
        }
    }


    /**
     * Summary of createApartmant
     * @param mixed $apartmant
     * @return void
     */
    private function createApartmant($apartmant): void 
    {
        $data = ['tower_id'=> $apartmant['resident']['tower_id'],
                'name'=> $apartmant['apartmant']['name']];
        $apartmant = Apartment::updateOrCreate($data);
    }

    
    /**
     * Summary of createAnimals
     * @param mixed $animals
     * @return void
     */
    private function createAnimals($animals) 
    {
       
        $animal = Animals::updateOrCreate($animals['animals']);         
       ResidentAnimals::updateOrCreate(
            [
                'animal_id'=> $animal->id, 
                'resident_id' => $animals['resident_id']
            ]);
                       
    }
    
    
    /**
     * Summary of createDrive
     * @param mixed $drives
     * @return void
     */
    private function createDrive($drives) 
    {        
       $drive = Drive::updateOrCreate($drives['drive']);       
        DriveResident::updateOrCreate(
            [
                'drive_id'=> $drive->id, 
                'resident_id' => $drives['resident_id']
            ]);
    }
    
    
    /**
     * Summary of createEmployee
     * @param mixed $employees
     * @return void
     */
    private function createEmployee($employees) 
    {
       $employee = Employee::updateOrCreate($employees['employee']);
        ResidentEmployee::updateOrCreate(
            [
                'employee_id'=> $employee->id, 
                'resident_id' => $employees['resident_id']
            ]
            );
    }

    
    /**
     * Cadastra as associações
     * @param array $data
     * @return void
     */
    private function createAssociate($data)
    {
     
        if (isset($data['animals']) && !empty($data['animals']['name'])) {
            //associar caso tenha animal
            $this->createAnimals($data);
        }
        
        if (isset($data['drive']) && !empty($data['drive']['description'])) {
            //associar caso tenha carro
            $this->createDrive($data);
        }
        
        if (isset($data['employee']) && !empty($data['employee']['name'])) {
            //associar empregada caso tenha
            $this->createEmployee($data);
        }

        if (isset($data['apartmant']) && !empty($data['apartmant'])) {
            $this->createApartmant($data);
        }
    }
    
   public function findWhereFirst(string $column, string $value)
   {
       return $this->resident->where($column, $value)->first(); // TODO: Change the autogenerated stub
   }

   public function paginate(int $perPage = 10): LengthAwarePaginator
   {
       return $this->resident->with(['user'])->paginate($perPage);
   }

    public function applyFilter(array $items)
    {
        $relationship = $this->relationship($this->resident);

        foreach ($items as $key => $value) {
            if ($value) {
                if (in_array($key, ['name', 'cpf','rg','birth_date','phone'])) {
                    if ($key == 'name') {
                        $relationship->whereRaw("UPPER(resident.name) like UPPER('%{$value}%')");
                    }
                    if ($key == 'cpf') {
                        $relationship->whereRaw("UPPER(resident.cpf) like UPPER('%{$value}%')");
                    }
                    if ($key == 'rg') {
                        $relationship->whereRaw("UPPER(resident.cpf) like UPPER('%{$value}%')");
                    }
                }
            }

        }
        $totalPage = 10;
        return $relationship->orderBy('resident.name')->paginate($totalPage);
    }

    /**
     * @return mixed
     */
    private function profile()
    {
        $profile = Profile::where('slug', 'morador')->first();
        return  $profile->id;
    }

    /**
     * @param $user
     * @param $profile
     * @return void
     */
    private function userProfile($user_id, $profile_id) 
    {
       UserProfile::created(['user_id' => $user_id, 'profile_id' => $profile_id]);
    }

    /**
     * Função que buscar os dados associados
     */
    private function relationship($entity) {

        return $entity->with('drive', 'animals', 'employee','user', 'condominium');
    }



}
