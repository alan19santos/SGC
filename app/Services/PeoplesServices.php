<?php
namespace App\Services;
use GuzzleHttp\Psr7\Request;
use App\Repositories\Core\PeoplesRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\People;


class PeoplesServices
{

    private $repository;

    /**
     * Summary of __construct
     * @param \App\Repositories\Core\PeoplesRepository $repository
     */
    public function __construct(PeoplesRepository $repository)
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
     * @return void
     */
    public function store($data)
    {
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
    public function destroy(int $id): void
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
     * Summary of storeFormData
     * @param mixed $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFormData($request)
    {
        $data = $request->all();
        \Log::debug('Dados recebidos do frontend:', $data);
        \Log::debug('Todos os arquivos:', $request->allFiles());

        if (count($this->repository->getEmailPeople($data['people']['email'])) > 0) {
            return response()->json(['success' => false, 'message' => 'Já existe esse EMAIL cadastrado!'], 400);
        }

        if ($this->repository->getPeopleCpf($data['people']['cpf'])) {
            return response()->json(['success' => false, 'message' => 'Já existe esse CPF cadastrado!'], 400);
        }
        try {
            // Verifica se a imagem foi enviada como 'photo' ou 'people[photo]'
            $photoFile = null;

            if ($request->hasFile('photo')) {
                $photoFile = $request->file('photo');
                \Log::info('Photo encontrado em: photo');
            } elseif ($request->hasFile('people.photo')) {
                $photoFile = $request->file('people.photo');
                \Log::info('Photo encontrado em: people.photo');
            } elseif (isset($data['people']['photo']) && !is_string($data['people']['photo'])) {
                $photoFile = $data['people']['photo'];
                \Log::info('Photo encontrado em: data[people][photo]');
            }

            if ($photoFile && $photoFile->isValid()) {
                $image = $photoFile;
                \Log::info('Arquivo válido recebido: ' . $image->getClientOriginalName());
                $data['people']['cpf'] = $this->formatNumber($data['people']['cpf']);
                $nameImage = $data['people']['cpf'] . '.' . $image->getClientOriginalExtension();
                if (file_exists(env('UPLOAD_IMAGE') . $nameImage)) {
                    unlink(env('UPLOAD_IMAGE') . $nameImage);
                }
                $image->storeAs('public/uploads', $nameImage);
                // Retornar o caminho acessível ao navegador
                $publicPath = asset('storage/uploads/' . $nameImage);
                $data['people']['photo'] = $publicPath;
                \Log::info('Arquivo armazenado com sucesso: ' . $publicPath);
                $this->repository->storeFormData($data);
                return response()->json(['success' => true, 'message' => 'Cadastrado com sucesso!'], 200);
            } elseif ($photoFile) {
                \Log::warning('Arquivo recebido mas inválido. Erro: ' . ($photoFile->getError() ?? 'desconhecido'));
                \Log::info('Continuando sem a foto...');
                $this->repository->storeFormData($data);
                return response()->json(['success' => true, 'message' => 'Cadastrado com sucesso! (sem foto)'], 200);
            } else {
                \Log::info('Nenhuma foto recebida, salvando sem foto');
                $this->repository->storeFormData($data);
                return response()->json(['success' => true, 'message' => 'Cadastrado com sucesso!'], 200);
            }
        } catch (\Exception $ex) {
            \Log::error('Erro ao salvar os dados:', [$ex->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Erro no cadastro de pessoa!'],500 );
        }
    }


    /**
     * Summary of updateFormData
     * @param mixed $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateFormData($request, $id) {
        $data = $request->all();
        \Log::debug('Dados recebidos no update:', $data);
        \Log::debug('Todos os arquivos no update:', $request->allFiles());

        $model = $this->findById($id);
        if (!$model) {
            return response()->json(['error' => false, 'message' => 'Erro ao atualizar pessoa!'],500 );
        }
        try {
                // Verifica se a imagem foi enviada como 'photo' ou 'people[photo]'
                $photoFile = null;

                if ($request->hasFile('photo')) {
                    $photoFile = $request->file('photo');
                    \Log::info('Photo encontrado em: photo (update)');
                } elseif ($request->hasFile('people.photo')) {
                    $photoFile = $request->file('people.photo');
                    \Log::info('Photo encontrado em: people.photo (update)');
                } elseif (isset($data['people']['photo']) && !is_string($data['people']['photo'])) {
                    $photoFile = $data['people']['photo'];
                    \Log::info('Photo encontrado em: data[people][photo] (update)');
                }

                if ($photoFile && $photoFile->isValid()) {
                    $image = $photoFile;
                    \Log::info('Arquivo válido recebido no update: ' . $image->getClientOriginalName());
                    $data['people']['cpf'] = $this->formatNumber($data['people']['cpf']);
                    $nameImage = $data['people']['cpf'] . '.' . $image->getClientOriginalExtension();
                    if (file_exists(env('UPLOAD_IMAGE') . $nameImage)) {
                        unlink(env('UPLOAD_IMAGE') . $nameImage);
                    }
                    $image->storeAs('public/uploads', $nameImage);
                    // Retornar o caminho acessível ao navegador
                    $publicPath = asset('storage/uploads/' . $nameImage);
                    $data['people']['photo'] = $publicPath;
                    \Log::info('Arquivo atualizado com sucesso: ' . $publicPath);
                } elseif ($photoFile) {
                    \Log::warning('Arquivo recebido mas inválido no update. Erro: ' . ($photoFile->getError() ?? 'desconhecido'));
                    \Log::info('Continuando a atualização sem alterar a foto...');
                    // Remove a foto dos dados para não limpar a foto existente
                    unset($data['people']['photo']);
                }

                $this->repository->updateFormData($model, $data);
                return response()->json(['success' => true, 'message' => 'Atualizado com sucesso!'], 200);

        } catch (\Exception $ex) {
            \Log::error('Erro ao atualizar os dados:', [$ex->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Erro ao atualizar pessoa!'],500 );
        }
    }

    /**
     * Summary of formatNumber
     * @param string $number
     * @return array|string|null
     */
    public function formatNumber(string $number) {
        $number = preg_replace('/[^0-9]/', '', $number);
        return $number;
    }

    /**
     * Summary of getPeopleCpf
     * @param mixed $cpf
     * @return mixed
     */
    public function getPeopleCpf($cpf) {
        return  $this->repository->getPeopleCpf($this->formatNumber($cpf));
    }


    /**
     * Summary of getTypeAccount
     * @return mixed
     */
    public function getTypeAccount() {
        return $this->repository->getTypeAccount();
    }

    /**
     * Summary of storeFormDataForAdmin para o filament
     * @param array $data
     * @throws \DomainException
     * @return \App\Models\Peoples|\Illuminate\Database\Eloquent\Model
     */
    public function storeFormDataForAdmin(array $data)
    {
        // validações de domínio (sem response)
        if ($this->repository->getEmailPeople($data['people']['email'])) {
            throw new \DomainException('Já existe esse EMAIL cadastrado!');
        }

        if ($this->repository->getPeopleCpf($data['people']['cpf'])) {
            throw new \DomainException('Já existe esse CPF cadastrado!');
        }

        // upload já vem tratado pelo Filament
        return $this->repository->storeFormDataForAdmin($data);
    }

    /**
     * Summary of updateForAdmin para o filament
     * @param array $data
     * @param int $id
     * @throws \DomainException
     * @return \App\Models\Peoples|\Illuminate\Database\Eloquent\Model
     */
    public function updateForAdmin(array $data, int $id)
    {
        $model = $this->findById($id);
        return $this->repository->updateForAdmin($model, $data);
    }


}
