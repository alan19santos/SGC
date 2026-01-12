<?php

namespace App\Services;
use App\Mail\ResidentMail;
use App\Repositories\Core\EmployeeRepository;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeService {

    private $repository;
    private $peopleService;

    public function __construct(EmployeeRepository $repository, PeoplesServices $peopleService) {
        $this->repository = $repository;
        $this->peopleService = $peopleService;
    }


    public function getAll() {
        return $this->repository->getAll();
    }

    /**
     * Summary of findById
     * @param mixed $id
     * @return object
     */
    public function findById($id) {
        return $this->repository->findById($id);
    }

    /* Summary of store
     * @param mixed $data
     * @return void
     */
    public function store($data) {
        $this->repository->store($data);
    }

    /**
     * Summary of paginate
     * @param int $id
     * @return LengthAwarePaginator
     */
    public function paginate(int $id): LengthAwarePaginator {
        return $this->repository->paginate($id);
    }

    /**
     * Summary of update
     * @param array $data
     * @param mixed $id
     * @return void
     */
    public function update(array $data, $id) {
        $model = $this->findById($id);
        $this->repository->update($model, $data);
    }

    /**
     * Summary of delete
     * @param int $id
     * @return void
     */
    public function destroy(int $id):void  {
        $model = $this->findById($id);
        $model->delete();
    }

    /**
     * Summary of restore
     * @param int $id
     * @return void
     */
    public function restore(int $id): void
    {
        $this->repository->restore($id);
    }

     /**
     * Summary of formatNumber
     * @param string $number
     * @return array|string|null
     */
    public function formatNumber(string $number) {
        $number = preg_replace('/[^0-9]/', '', $number);
        return $number;
    }

   public function storeFormData($request) {
        $data = $request->all();
        try {
            if ($request->hasFile('photo')) {
                $use = $this->repository->createUser($data);
                if (!empty($use)) {
                    $data['employee']['users_id'] = $use;
                    $image = $request->file('photo');
                    $data['employee']['cpf'] = $this->formatNumber($data['employee']['cpf']);
                    $nameImage = $data['employee']['cpf'] . '.' . $image->getClientOriginalExtension();
                    if (file_exists(env('UPLOAD_IMAGE') . $nameImage)) {
                        unlink(env('UPLOAD_IMAGE') . $nameImage);
                    }
                    $image->storeAs('public/uploads', $nameImage);
                    $publicPath = asset('storage/uploads/' . $nameImage);
                    $data['employee']['photo'] = $publicPath;
                    if ($use) {
                        $this->sendMail( $use, 'Confirmação de cadastro:  Sistema SGC');
                    }
                    return $this->store($data['employee']);
                } else {
                    throw new Exception('Erro ao criar o usuário');
                }
            } else if (!empty($data['employee']['photo'])) {
                $use = $this->repository->createUser($data);
                if (!empty($use)) {
                    return $this->store($data['employee']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Erro no cadastro de Funcionário, falha na imagem!'],500 );
            }
        } catch (\Exception $ex) {
            \Log::error('Erro ao salvar os dados:', [$ex->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Erro no cadastro de Funcionário!'],500 );
        }

    }


    public function updateFormData($request, $id) {
        $data = $request->all();

        try{
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $data['employee']['cpf'] = $this->formatNumber($data['employee']['cpf']);
                $nameImage = $data['employee']['cpf'] . '.' . $image->getClientOriginalExtension();
                if (file_exists(env('UPLOAD_IMAGE') . $nameImage)) {
                    unlink(env('UPLOAD_IMAGE') . $nameImage);
                }
                $image->storeAs('public/uploads', $nameImage);
                $publicPath = asset('storage/uploads/' . $nameImage);
                $data['employee']['photo'] = $publicPath;
                return $this->update($data['employee'], $id);
            } else if (!empty($data['employee']['photo'])) {
                return $this->update($data['employee'], $id);
            } else {
                return response()->json(['success' => false, 'message' => 'Erro no cadastro de Funcionário, falha na imagem!'],500 );
            }
        }  catch (\Exception $ex) {
             \Log::error('Erro ao salvar os dados:', [$ex->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Erro no cadastro de Funcionário!'],500 );
        }


    }

    public function getPeopleCpf(string $cpf) {

        return $this->peopleService->getPeopleCpf($cpf);
    }

    public function getType() {
        return $this->repository->getType();
    }

    private function sendMail($data, $title) {
        $mail = new ResidentMail($data['email'], $title);

        $mail->send($data);
    }

}
