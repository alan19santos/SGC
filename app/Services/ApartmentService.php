<?php


namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Core\ApartmentRepository;

/**
 * Summary of ApartmentService
 */
class ApartmentService {

    /**
     * Summary of repository
     * @var
     */
    private $repository;

    public function __construct(ApartmentRepository $repository) {
        $this->repository = $repository;
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

    /**
     * Summary of store
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
     * Summary of getTowerApartment
     * @param int $id
     */
    public function getTowerApartment(int $id) {

        return $this->repository->getTowerApartment($id);
    }
}
