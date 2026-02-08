<?php

namespace App\Services;

use App\Repositories\Core\RevenueExpenseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
class RevenueExpenseService
{

    private RevenueExpenseRepository $repository;

    public function __construct(RevenueExpenseRepository $repository)
    {
        $this->repository = $repository;
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
     * Summary of getAll
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function findById(int $id): object
    {
        return $this->repository->findById($id);
    }

    public function update(array $data, int $id)
    {
        $model = $this->findById($id);
        return $this->repository->update($model, $data);
    }

    public function store(array $data)
    {
        $data['transaction_date'] = Carbon::now()->toDateString();
        return $this->repository->store($data);
    }

    public function destroy(int $id)
    {
        $model = $this->findById($id);
        return $this->repository->delete($model);
    }

    public function getCategories()
    {
        return $this->repository->getCategories();
    }

    public function getTypes()
    {
        return $this->repository->getTypes();
    }
}
