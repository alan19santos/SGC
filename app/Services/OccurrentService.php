<?php

namespace App\Services;
use GuzzleHttp\Psr7\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Core\OccurrentRepository;


class OccurrentService {

    /**
     * Summary of repository
     * @var
     */
    private $repository;

    /**
     * Summary of __construct
     * @param \App\Repositories\Core\OccurrentRepository $repository
     */
    public function __construct(OccurrentRepository $repository) {
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
     * @return LengthAwarePaginator
     */
    public function paginate(int $id): LengthAwarePaginator {
        return $this->repository->paginate($id);
    }

    /**
     * Summary of store
     * @param mixed $data
     * @return void
     */
    public function store($data) {

        $data['user_id'] = Auth::id();
        $data['date_occurrence'] = date('Y-m-d H:i:s');
        $data['resolution'] = false;
        $this->repository->store($data);
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
     * Summary of typeOccurrence
     */
    public function typeOccurrence() {
        return $this->repository->typeOccurrence();
    }

    public function statusOccurrence() {
        return $this->repository->statusOccurrence();
    }

    /**
     * Summary of storeHistoric
     * @param array $data
     */
    public function storeHistoric(array $data) {

        return $this->repository->storeHistoric($data);
    }
}
