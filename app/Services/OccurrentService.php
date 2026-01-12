<?php

namespace App\Services;
use GuzzleHttp\Psr7\Request;
use App\Services\EmployeeService;
use App\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Core\OccurrentRepository;
use App\Enums\StatusOccurrenceEnums;


class OccurrentService {

    /**
     * Summary of repository
     * @var
     */
    private $repository;
    private $employeeService;

    /**
     * Summary of __construct
     * @param OccurrentRepository $repository
     * @param EmployeeService $employeeService
     */
    public function __construct(OccurrentRepository $repository, EmployeeService $employeeService) {
        $this->repository = $repository;
        $this->employeeService = $employeeService;
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

        $data['occurrence']['user_id'] = (!isset($data['responsible_id']) || empty($data['responsible_id']) ? Auth::id() : $data['responsible_id']);

        $resident = $this->repository->getResident(Auth::id());

        $data['occurrence']['condominium_id'] = (!isset($data['responsible_id']) || empty($data['responsible_id']) ? $resident->condominium_id : $data['occurrence']['condominium_id']);
        $data['occurrence']['date_occurrence'] = date('Y-m-d H:i:s');
        $data['occurrence']['resolution'] = false;
        $data['occurrence']['previsibles_days'] = (!isset($data['previsibles_days']) || empty($data['previsibles_days']) ? 5 : $data['responsible_id']);
        $data['occurrence']['resident_id'] = $resident->id;
        $status = $this->repository->statusOccurrence(StatusOccurrenceEnums::ABERTA);
        $data['occurrence']['status_occurrence_id'] = (!isset($data['status_occurrence_id']) || empty($data['status_occurrence_id']) ? $status->id : $data['status_occurrence_id']);


        $this->repository->store($data);
    }

    /**
     * Summary of update
     * @param array $data
     * @param mixed $id
     * @return void
     */
    public function update(array $data, $id) {
        $occurrence = $this->findById($id);
        $status = $this->repository->statusOccurrence(StatusOccurrenceEnums::CONCLUIDO);
        if (isset($data['data']['responsible_id']) && !empty($data['data']['responsible_id'])) {
            $user = $this->employeeService->findById($data['data']['responsible_id']);
            $data['data']['occurrence_id'] = $occurrence->id;
            $data['data']['users_id'] = $user->users_id;
            $data['data']['resolution'] = ($status->id != $data['data']['status_occurrence_id'] ? false : true);

            $this->repository->responsibleAtrbuition($data['data']);
        }
        unset($data['data']['occurrence_id']);
        unset($data['data']['responsible_id']);
        $this->repository->update($occurrence, $data['data']);
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
