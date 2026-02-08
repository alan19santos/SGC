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
use App\Enums\StatusPriorityEnums;
use App\Mail\EmployeeMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class OccurrentService {

    /**
     * Summary of repository
     * @var
     */
    private $repository;
    private $employeeService;

    const ROWS_OCCURRENCE = 3;
    const FINE_AMOUNT = 50.00;

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
    public function store(array $data) {

        $data['occurrence']['user_id'] = (!isset($data['responsible_id']) || empty($data['responsible_id']) ? Auth::id() : $data['responsible_id']);
        $userId = $data['occurrence']['user_id'];
        $resident = $this->repository->getResident(Auth::id());

        $data['occurrence']['condominium_id'] = (!isset($data['responsible_id']) || empty($data['responsible_id']) ? $resident->condominium_id : $data['occurrence']['condominium_id']);
        $data['occurrence']['date_occurrence'] = date('Y-m-d H:i:s');
        $data['occurrence']['resolution'] = false;
        $data['occurrence']['previsibles_days'] = (!isset($data['previsibles_days']) || empty($data['previsibles_days']) ? 5 : $data['previsibles_days']);
        // $data['occurrence']['resident_id'] = $resident->id;
        $status = $this->repository->statusOccurrence(StatusOccurrenceEnums::ABERTA);
        $priority = $this->repository->statusPriority(StatusPriorityEnums::MEDIA);
        $data['occurrence']['status_occurrence_id'] = (!isset($data['status_occurrence_id']) || empty($data['status_occurrence_id']) ? $status->id : $data['status_occurrence_id']);
        $data['occurrence']['status_priority_id'] = (!isset($data['status_priority_id']) || empty($data['status_priority_id']) ? $priority->id : $data['status_priority_id']);
        $occurrence = $this->repository->storeModel($data);
        Log::debug('retorno da ocorrencia', ['ocorrencia'=> $occurrence]);
        //enviar email
        $user = $this->employeeService->findById($userId);
        $countResident = $this->repository->getCountOccurrencesByResident($data['occurrence']['resident_id']);

        // SE O NÚMERO DE OCORRÊNCIAS FOR MAIOR OU IGUAL A 3, GERAR MULTA AUTOMATICAMENTE
        if ($countResident >= self::ROWS_OCCURRENCE) {
            $fines = $this->repository->storeFine([
                'condominium_id' => $resident->condominium_id,
                'resident_id' => $data['occurrence']['resident_id'],
                'occurrence_id' => $occurrence->id,
                'amount' => self::FINE_AMOUNT, // cria uma tabela de preço por condominio depois
                'issued_at' => Carbon::today(),
                'due_date' => Carbon::today()->addDays(7), // cria uma regra de negocio depois para cada condominio
            ]);

            Log::debug('retorno da multa', ['multa'=> $fines]);
        }
        $this->sendMail($user,'Abertura de chamado', $occurrence);
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
        // Log::debug('retorno do usuário', ['usuarios'=> $user->id, 'ocorrencia' => $id]);
        $this->sendMail($user,'Abertura de chamado', $occurrence);
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

    public function statusPriority() {
        return $this->repository->statusPriority();
    }

    /**
     * Summary of storeHistoric
     * @param array $data
     */
    public function storeHistoric(array $data) {

        return $this->repository->storeHistoric($data);
    }

    /**
     * Envio de email quando ocorrencia é criada ou atualizada
     * @param mixed $data
     * @param mixed $title
     * @param mixed $occurrence
     */
    private function sendMail($data, $title, $occurrence = null) {
        $userSErvice = App::make(UserService::class);
        $user = $userSErvice->findById($data->users_id);
// Log::debug('retorno do usuário', ['usuarios'=> $user->email, 'ocorrencia' => $data]);
        $mail = new EmployeeMail($user->email, $title);
        $data['number'] = $occurrence->id ?? $occurrence->id;
        $mail->send($data);
    }
}
