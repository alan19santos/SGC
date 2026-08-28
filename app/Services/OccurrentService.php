<?php

namespace App\Services;
use GuzzleHttp\Psr7\Request;
use App\Services\EmployeeService;
use App\Services\UserService;
use App\Services\ResidentService;
use App\Services\FineService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Core\OccurrentRepository;
use App\Enums\StatusOccurrenceEnums;
use App\Enums\StatusPriorityEnums;
use App\Enums\FinancyTypeEnums;
use App\Enums\FinancyStatusEnums;
use App\Mail\EmployeeMail;
use App\Mail\ResidentMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class OccurrentService {

    /**
     * Summary of repository
     * @var
     */
    private $repository;
    private $employeeService;
    private $residentService;
    private $fineService;
    const ROWS_OCCURRENCE = 3;
    const FINE_AMOUNT = 50.00;

    /**
     * Summary of __construct
     * @param OccurrentRepository $repository
     * @param EmployeeService $employeeService
     * @param ResidentService $residentService
     * @param FineService $fineService
     */
    public function __construct(OccurrentRepository $repository, EmployeeService $employeeService, ResidentService $residentService, FineService $fineService) {
        $this->repository = $repository;
        $this->employeeService = $employeeService;
        $this->residentService = $residentService;
        $this->fineService = $fineService;
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
     * Summary of arrayOccurrence
     * @param mixed $data
     * @return array{condominium_id: mixed, date_occurrence: string, observations: mixed, previsibles_days: mixed, resident_id: mixed, resolution: bool, status_occurrence_id: mixed, status_priority_id: mixed, title: mixed, type_occurrence_id: mixed, user_id: mixed}
     */
    private function arrayOccurrence($data) {
        return [
            'title' => $data['title'],
            'observation' => $data['observations'],
            'date_occurrence' => date('Y-m-d H:i:s'),
            'resolution' => false,
            'responsible_id' => (!isset($data['responsible_id']) || empty($data['responsible_id']) ? Auth::id() : $data['responsible_id']),
            'previsibles_days' => (!isset($data['previsibles_days']) || empty($data['previsibles_days']) ? 5 : $data['previsibles_days']),
            'resident_id' => $data['resident_id'] ?? null,
            'user_id' => (!isset($data['responsible_id']) || empty($data['responsible_id']) ? Auth::id() : $data['responsible_id']),
            'condominium_id' => $data['condominium_id'],
            'status_occurrence_id' => (!isset($data['status_occurrence_id']) || empty($data['status_occurrence_id']) ? $this->repository->statusOccurrence(StatusOccurrenceEnums::ABERTA)->id : $data['status_occurrence_id']),
            'status_priority_id' => (!isset($data['status_priority_id']) || empty($data['status_priority_id']) ? $this  ->repository->statusPriority(StatusPriorityEnums::MEDIA)->id : $data['status_priority_id']),
            'type_occurrence_id' => (!isset($data['type_occurrence_id']) || empty($data['type_occurrence_id']) ? $this->repository->typeOccurrence(FinancyTypeEnums::MULTA_APLICADA)->id : $data['type_occurrence_id']),
        ];
    }


    private function finacyStatus($slug) {
        return $this->fineService->financyStatus($slug);
    }



    /* Summary of store
     * @param array $data
     * @return void
     */
    public function store(array $data)
    {
        $isResponsible = isset($data['occurrence']['responsible_id']) && !empty($data['occurrence']['responsible_id']) ? true : false;

        // Se responsible_id está no nível raiz (enviado pelo front), mover para dentro de occurrence
        if (!$isResponsible && isset($data['responsible_id']) && !empty($data['responsible_id'])) {
            $data['occurrence']['responsible_id'] = $data['responsible_id'];
            $isResponsible = true;
        }

        $isResident = isset($data['occurrence']['resident_id']) && !empty($data['occurrence']['resident_id']) ? true : false;
        Log::debug('Dados recebidos para criar ocorrência: ', ['data' => $data]);
        try {

            $resident = $this->repository->getResident(Auth::id());

            // validar se o condomínio_id foi enviado no request, se não tiver, pegar do morador autenticado, se não tiver, lançar uma exceção
            $condominiumId = null;
            if (isset($data['occurrence']['condominium_id']) && !empty($data['occurrence']['condominium_id'])) {
                $condominiumId = $data['occurrence']['condominium_id'];
            } elseif ($resident) {
                $condominiumId = $resident->condominium_id;
                $data['occurrence']['condominium_id'] = $condominiumId;
            } else {
                // Fallback: buscar pela tabela condominium_user
                $condominiumUser = \App\Models\CondominiumUser::where('user_id', Auth::id())->first();
                if ($condominiumUser) {
                    $condominiumId = $condominiumUser->condominium_id;
                    $data['occurrence']['condominium_id'] = $condominiumId;
                }
            }

            if (!$condominiumId) {
                throw new \DomainException('Condomínio não encontrado para o usuário autenticado.');
            }

            $occurrence['occurrence'] = $this->arrayOccurrence($data['occurrence']);
            // Log::debug('Dados formatados para criar ocorrência: ', ['occurrence' => $occurrence]);

            $occurrence = $this->repository->storeModel($occurrence);

            $typeOccurrence = $this->repository->typeOccurrence(FinancyTypeEnums::MULTA_APLICADA);


            // dados do responsável pela ocorrência, para enviar email de notificação
            // Se o responsável for definido no momento da criação da ocorrência, usar os dados do responsável, caso contrário, usar os dados do administrador
            if ($isResponsible) {
                $user = $this->employeeService->findById($data['occurrence']['responsible_id']);
            } else {
                $userService = App::make(UserService::class);
                $user = $userService->findByEmail('ADMINISTRADOR@SGC.COM.BR');

            }

            if ($isResident) {
                 // Verificar o número de ocorrências do morador
                 $countResident = $this->repository->getCountOccurrencesByResident($data['occurrence']['resident_id']);

                // SE O NÚMERO DE OCORRÊNCIAS FOR MAIOR OU IGUAL A 3, OU SE FOR DO TIPO MULTA_APLICADA, GERAR MULTA AUTOMATICAMENTE
                if ($data['occurrence']['type_occurrence_id'] == $typeOccurrence->id || $countResident >= self::ROWS_OCCURRENCE) {
                    $fines = $this->repository->storeFine([
                        'condominium_id' => $condominiumId,
                        'financial_status_id' => $this->finacyStatus(FinancyStatusEnums::PENDENTE)->id, // 1 = Pendente
                        'resident_id' => $data['occurrence']['resident_id'],
                        'occurrence_id' => $occurrence->id,
                        'amount' => self::FINE_AMOUNT, // cria uma tabela de preço por condominio depois
                        'issued_at' => Carbon::today(),
                        'due_date' => Carbon::today()->addDays(7), // cria uma regra de negocio depois para cada condominio
                    ]);

                    Log::debug('retorno da multa', ['multa' => $fines]);
                }
            }



            //Criar notificação para morador que esta recebendo a denuncia/ocorrencia
            if ($isResident) {
                $notifications = $this->repository->storeNotification([
                    'title' => $data['occurrence']['title'] ?? 'Nova ocorrência registrada',
                    'message' => $data['occurrence']['observations'] ?? 'Uma nova ocorrência foi registrada em seu nome. Por favor, verifique os detalhes e tome as medidas necessárias.',
                    'read' => false,
                    'user_id' => $this->residentService->findWhereFirst('id', $data['occurrence']['resident_id'])->user_id,
                ]);

                Log::debug('retorno da notificação morador', ['notificação' => $notifications]);

                // busca os dados do marador para enviar a notificação
                $dataResidente = $this->residentService->findWhereFirst('id', $data['occurrence']['resident_id']);
                $this->sendNotification($dataResidente, $data['occurrence']['title'] ?? 'Nova ocorrência registrada', $occurrence, $data['occurrence']['observations']);
            }

            //Criar notificação para o funcionário responsável pela ocorrência
            if ($isResponsible || ($user && isset($user->id))) {
                $userId = $isResponsible ? $this->employeeService->findWhereFirst('id', $data['occurrence']['responsible_id'])->user_id : $user->id;
                $notifications = $this->repository->storeNotification([
                    'title' => $data['occurrence']['title'] ?? 'Nova ocorrência registrada',
                    'message' => $data['occurrence']['observations'] ?? 'Uma nova ocorrência foi registrada. Por favor, verifique os detalhes e tome as medidas necessárias.',
                    'read' => false,
                    'user_id' => $userId,
                ]);

                Log::debug('retorno da notificação funcionário', ['notificação' => $notifications]);

                    if ($isResponsible) {
                        // busca os dados do funcionário para enviar a notificação
                        $dataFuncionario = $this->employeeService->findWhereFirst('id', $data['occurrence']['responsible_id']);
                        $this->sendNotification($dataFuncionario, $data['occurrence']['title'] ?? 'Nova ocorrência registrada', $occurrence, $data['occurrence']['observations']);
                    }
                }


            if ($isResponsible) {
                //enviar email
                $this->sendMail($user, 'Abertura de chamado', $occurrence);
            }

        } catch (\DomainException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            Log::error('Erro ao criar ocorrência: ', ['message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()]);
            throw new \DomainException('Erro ao criar ocorrência. Por favor, tente novamente.');
        }
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
            $data['data']['observation'] = $data['data']['observations'] ?? '';

            $this->repository->responsibleAtrbuition($data['data']);
            $notifications = $this->repository->storeNotification([
                'title' => 'Atualização de ocorrência',
                'message' => !empty($data['data']['observations']) ? $data['data']['observations'] : 'A ocorrência #' . $occurrence->id . ' foi atualizada. Por favor, verifique os detalhes e tome as medidas necessárias.',
                'read' => false,
                'user_id' => $user->users_id,
            ]);

            Log::debug('retorno da notificação morador', ['notificação' => $notifications]);
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

    public function getAllByResident(int $residentId) {
        return $this->repository->getAllByResident($residentId);
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

        $mail = new EmployeeMail($user->email, $title);
        $data['number'] = $occurrence->id ?? $occurrence->id;
        $mail->send($data);
    }


    /**
     * Summary of sendNotification
     * @param mixed $data
     * @param mixed $title
     * @param mixed $occurrence
     * @param mixed $message
     * @return void
     */
    private function sendNotification($data, $title, $occurrence = null, $message = null) {

        $userSErvice = App::make(UserService::class);
        $user = $userSErvice->findById($data->user_id);

        $mail = new ResidentMail($user->email, $title);
        $data['number'] = $occurrence->id ?? $occurrence->id;
        $data['message'] = $message ?? 'Uma nova ocorrência foi registrada em seu nome. Por favor, verifique os detalhes e tome as medidas necessárias.';
        $data['email'] = $user->email;
        $mail->sendNotification($data);

    }

    public function applyFilter(array $items) {

        return $this->repository->applyFilter($items);
    }

}
