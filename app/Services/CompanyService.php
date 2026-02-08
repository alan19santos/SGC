<?php

namespace App\Services;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Core\CompanyRepository;
class CompanyService {
    private $repository;

    /**
     * Summary of __construct
     * @param CompanyRepository $repository
     */
    public function __construct(CompanyRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Summary of getAll
     * @return \Illuminate\Database\Eloquent\Collection
     */
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

    /**
     * Summary of store
     * @param mixed $data
     * @return void
     */
    public function store($data) {
        $data['cnpj'] = $this->formatCNPJ($data['cnpj']);
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
        $data['cnpj'] = $this->formatCNPJ($data['cnpj']);
        $this->repository->update($model, $data);
    }

    /**
     * Summary of destroy
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
     * Summary of formatCNPJ
     * @param mixed $cnpj
     * @return string
     */
    public function formatCNPJ($cnpj): string {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        return substr($cnpj, 0, 2) . '.' .
               substr($cnpj, 2, 3) . '.' .
               substr($cnpj, 5, 3) . '/' .
               substr($cnpj, 8, 4) . '-' .
               substr($cnpj, 12, 2);
    }


}
