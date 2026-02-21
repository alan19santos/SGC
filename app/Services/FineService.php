<?php

namespace App\Services;

use GuzzleHttp\Psr7\Request;
use App\Repositories\Core\FineRepository;

class FineService {

    /**
     * Summary of repository
     * @var
     */
    private $repository;

    /**
     * Summary of __construct
     * @param FineRepository $repository
     */
    public function __construct(FineRepository $repository) {
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
     * Summary of paginate
     * @param int $id
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return bool|null
     */
    public function destroy(int $id)
    {
        $model = $this->findById($id);
        return $this->repository->delete($model);
    }

    public function financyStatus(string $slug) {
        return $this->repository->financyStatus($slug);
    }

}
