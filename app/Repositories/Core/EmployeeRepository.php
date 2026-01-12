<?php


namespace App\Repositories\Core;

use App\Models\Employee;
use App\Models\User;
use App\Models\Profile;
use App\Models\TypeEmployee;
use App\Enums\ProfileEnums;
use App\Repositories\Core\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class EmployeeRepository extends BaseRepository {


    private $modalUser;

    public function __construct(private Employee $entity) {

        parent::__construct($entity);
        $this->modalUser = new User();
    }

    public function getAll(): Collection {

        return $this->relationship($this->entity)->get();
    }

    private function relationship($entity, $relations = []) {
        return $entity->with($relations);
    }

    public function findWhere(string $columnm, string $value): Collection {
        return parent::findWhere($columnm, $value);
    }

    public function paginate(int $totalPage = 10): LengthAwarePaginator
    {
        return parent::paginate($totalPage);
    }


    public function getType() {
        return TypeEmployee::all();
    }


    public function getCpf(string $cpf) {
        return $this->entity->where('cpf','='. $cpf)->first();
    }

    public function createUser(array $data) {
        $profile = Profile::where('slug', '=', ProfileEnums::FUNCIONARIO)->first();

        $user = ['name' => $data['employee']['name'], 'email' => $data['user']['email'], 'profile_id' => $profile->id, 'password' => Hash::make(Str::random(10))];
        $usu = $this->modalUser->create($user);

        return $usu->id;
    }


}
