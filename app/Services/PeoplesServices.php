<?php
namespace App\Services;
use GuzzleHttp\Psr7\Request;
use App\Repositories\Core\PeoplesRepository;
use Illuminate\Pagination\LengthAwarePaginator;


class PeoplesServices
{

    private $repository;

    /**
     * Summary of __construct
     * @param \App\Repositories\Core\PeoplesRepository $repository
     */
    public function __construct(PeoplesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Summary of getAll
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->repository->getAll();
    }

    /**
     * Summary of findById
     * @param mixed $id
     * @return object
     */
    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    /**
     * Summary of store
     * @param mixed $data
     * @return void
     */
    public function store($data)
    {
        $this->repository->store($data);
    }

    /**
     * Summary of paginate
     * @param int $id
     * @return LengthAwarePaginator
     */
    public function paginate(int $id): LengthAwarePaginator
    {
        return $this->repository->paginate($id);
    }

    /**
     * Summary of update
     * @param array $data
     * @param mixed $id
     * @return void
     */
    public function update(array $data, $id)
    {
        $model = $this->findById($id);
        $this->repository->update($model, $data);
    }

    /**
     * Summary of delete
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
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

    public function storeFormData($request)
    {
        $data = $request->all();
        try {
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $data['people']['cpf'] = $this->formatNumber($data['people']['cpf']);
                $nameImage = $data['people']['cpf'] . '.' . $image->getClientOriginalExtension();
                if (file_exists(env('UPLOAD_IMAGE') . $nameImage)) {
                    unlink(env('UPLOAD_IMAGE') . $nameImage);
                }
                $image->storeAs('public/uploads', $nameImage);
                // Retornar o caminho acessível ao navegador
                $publicPath = asset('storage/uploads/' . $nameImage);
                $data['people']['photo'] = $publicPath;
                $this->repository->storeFormData($data);
            }
        } catch (\Exception $ex) {
            \Log::error('Erro ao salvar os dados:', [$ex->getMessage()]);
        }
    }


    public function updateFormData($request, $id) {
        $data = $request->all();
        $model = $this->findById($id);
        try {
                $image = $request->file('photo');
                if (!empty($image)) {
                    $data['people']['cpf'] = $this->formatNumber($data['people']['cpf']);
                    $nameImage = $data['people']['cpf'] . '.' . $image->getClientOriginalExtension();
                    if (file_exists(env('UPLOAD_IMAGE') . $nameImage)) {
                        unlink(env('UPLOAD_IMAGE') . $nameImage);
                    }
                    $image->storeAs('public/uploads', $nameImage);
                    // Retornar o caminho acessível ao navegador
                    $publicPath = asset('storage/uploads/' . $nameImage);
                    $data['people']['photo'] = $publicPath;
                }
                $this->repository->updateFormData($model, $data);

        } catch (\Exception $ex) {
            \Log::error('Erro ao salvar os dados:', [$ex->getMessage()]);
        }
    }

    public function formatNumber(string $number) {
        $number = preg_replace('/[^0-9]/', '', $number);
        return $number;
    }

    public function getPeopleCpf($cpf) {
        return  $this->repository->getPeopleCpf($this->formatNumber($cpf));
    }


}
