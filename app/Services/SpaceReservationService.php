<?php

namespace App\Services;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Core\SpaceReservationRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpaceReservationService {

    private $repository;

    public function __construct(SpaceReservationRepository $repository) {
        $this->repository = $repository;
    }

    public function getAll() {
        return $this->repository->getAll();
    }

    public function findById($id) {
        return $this->repository->findById($id);
    }

    public function store($data) {
        
        $reserved = $this->repository->applyFilter($data);
        if ($reserved['total'] > 0) {
            return ['success'=> false, 'message'=>'Já existe uma reserva nesta data e hora!'];
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

    public function isValidade(array $value, int $id) {

        $model = $this->findById($id);
        return $this->repository->isValidade($model, $value);
    }

    public function typeReserved() {
        return $this->repository->typeReserved();
    }
}

