<?php
namespace App\Services;

use App\Repositories\Core\VisitorsRepositories;
use App\Services\PeoplesServices;
use Illuminate\Pagination\LengthAwarePaginator;

class VisitorsService {

    private $repository;
    private $peopleService;
    public function __construct(VisitorsRepositories $repository, PeoplesServices $peopleService) {
        $this->repository = $repository;
        $this->peopleService = $peopleService;
    }

    public function getAll() {
        return $this->repository->getAll();
    }

    public function findById($id) {
        return $this->repository->findById($id);
    }

    public function store($data) {
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

    public function getPeopleCpf(string $cpf) {
        return $this->peopleService->getPeopleCpf($cpf);

    }

    public function getVisitorCondominium(): void
    {
        $this->repository->getVisitorCondominium();
    }

}
