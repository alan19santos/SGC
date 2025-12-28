<?php

namespace App\Services;
use App\Repositories\Core\ServiceProviderRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\PeoplesServices;

class ServiceProviderService {

    private $repository;
    private $peopleService;

    public function __construct(ServiceProviderRepository $repository, PeoplesServices $peopleService)
    {
        $this->repository = $repository;
        $this->peopleService = $peopleService;
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

    public function getPeopleCpf(string $cpf) {
        return $this->peopleService->getPeopleCpf($cpf);

    }

}
