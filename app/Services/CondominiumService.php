<?php

namespace App\Services;
use App\Repositories\Core\CondominiumRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CondominiumService
{

    /**
     * Summary of repository
     * @var
     */
    private $repository;

    /**
     * Summary of __construct
     * @param \App\Repositories\Core\CondominiumRepository $repository
     */
    public function __construct(CondominiumRepository $repository)
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
     * @return array{message: string} | null
     */
    public function store($data)
    {
        $nameCondominium = $this->repository->findByName($data['name']);
        if ($nameCondominium) {
            return ['message' => 'Condominio já foi cadastrado'];
        }
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

    /**
     * Summary of storeForAdmin para o filament
     * @param array $data
     * @throws \DomainException
     * @return \App\Models\Condominium
     */
    public function storeForAdmin(array $data)
    {
        if ($this->repository->findByName($data['name'])) {
            throw new \DomainException('Condomínio já foi cadastrado');
        }

        return $this->repository->storeForAdmin($data);
    }

    /**
     * Summary of updateForAdmin para o filament
     * @param array $data
     * @param int $id
     */
    public function updateForAdmin(array $data, int $id)
    {
        $model = $this->findById($id);
        return $this->repository->updateForAdmin($model, $data);
    }
}
