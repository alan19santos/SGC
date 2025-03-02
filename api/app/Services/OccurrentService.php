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
    private $repository;

    public function __construct(OccurrentRepository $repository) {
        $this->repository = $repository;
    }   

    public function getAll() {
        return $this->repository->getAll();
    }

    public function findById($id) {
        return $this->repository->findById($id);
    }

    public function paginate(int $id): LengthAwarePaginator {
        return $this->repository->paginate($id);
    }

    public function store($data) {

        $data['user_id'] = Auth::id();
        $data['date_occurrence'] = date('Y-m-d H:i:s');
        $data['resolution'] = false;
        $this->repository->store($data);
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

    public function typeOccurrence() {
        return $this->repository->typeOccurrence();
    }
}