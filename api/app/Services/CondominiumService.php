<?php

namespace App\Services;
use App\Repositories\Core\CondominiumRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CondominiumService {

    private $repository;
    public function __construct(CondominiumRepository $repository) {
        $this->repository = $repository;
    }

    public function getAll() {
        return $this->repository->getAll();
    }

    public function findById($id) {
        return $this->repository->findById($id);
    }

    public function store($data) {
        $nameCondominium = $this->repository->findByName($data['name']);
        if ($nameCondominium) {
            return ['message' => 'Condominio já foi cadastrado'];
        }
        $this->repository->store($data);
    }

    public function paginate(int $id): LengthAwarePaginator {
        return $this->repository->paginate($id);
    }

    public function update(array $data, $id) {
        $model = $this->findById($id);
        $this->repository->update($model, $data);
    }

    public function delete(int $id):void  {
        $model = $this->findById($id);
        $model->delete();
    }

    public function restore(int $id): void
    {
        $this->repository->restore($id);
    }
}
