<?php

namespace App\Services;
use App\Repositories\Core\ProfileRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileService {

    /**
     * Summary of repository
     * @var
     */
    private $repository;

    /**
     * Summary of __construct
     * @param \App\Repositories\Core\ProfileRepository $repository
     */
    public function __construct(ProfileRepository $repository) {
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
     * Summary of filterSlug
     * @param string $slug
     * @return void
     */
    public function filterSlug(string $slug) {
        $this->repository->filterSlug($slug);
    }

    /**
     * Summary of filterSlugId
     * @param int $id
     * @return void
     */
    public function filterSlugId(int $id) {
        $this->repository->filterSlugId($id);
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
}
