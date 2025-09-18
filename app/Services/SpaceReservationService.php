<?php

namespace App\Services;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Core\SpaceReservationRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpaceReservationService {

    private $repository;

    /**
     * Summary of __construct
     * @param \App\Repositories\Core\SpaceReservationRepository $repository
     */
    public function __construct(SpaceReservationRepository $repository) {
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
     * @return array{message: string, success: bool} | null
     */
    public function store($data) {

        $reserved = $this->repository->applyFilter($data);
        if ($reserved['total'] > 0) {
            return ['success'=> false, 'message'=>'Já existe uma reserva nesta data e hora!'];
        }
        $this->repository->store($data);
    }

    /**
     * Summary of paginate
     * @param int $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
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
    public function delete(int $id):void  {
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
     * Summary of isValidade
     * @param array $value
     * @param int $id
     */
    public function isValidade(array $value, int $id) {

        $model = $this->findById($id);
        return $this->repository->isValidade($model, $value);
    }

    /**
     * Summary of typeReserved
     * @return \App\Models\TypeReserved[]|\Illuminate\Database\Eloquent\Collection
     */
    public function typeReserved() {
        return $this->repository->typeReserved();
    }
}

