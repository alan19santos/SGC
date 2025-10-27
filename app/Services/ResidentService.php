<?php

namespace App\Services;
use App\Repositories\Core\ResidentRepository;
use App\Services\PeoplesServices;
use GuzzleHttp\Psr7\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


/**
 * Summary of ResidentService
 */
class ResidentService {
    private $repository;
    private $peopleService;
    /**
     * Summary of __construct
     * @param \App\Repositories\Core\ResidentRepository $repository
     */
    public function __construct(ResidentRepository $repository, PeoplesServices $peopleService)
    {
        $this->repository = $repository;
        $this->peopleService = $peopleService;
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
    public function paginate(int $id) {
        return $this->repository->paginate($id);
    }

    /**
     * Summary of store
     * @param array $data
     * @return array{message: string, success: bool}
     */
    public function store(array $data) {

        $email = $data['resident']['email'];
        // Log::debug('dados do resident',[$data]);
        $user = $this->repository->getUserByEmail($email);
        $data['resident']['cpf'] = $this->repository->formatNumber($data['resident']['cpf']);

        if (isset( $data['employer']['cpf'])) {
            $data['employer']['cpf'] = $this->repository->formatNumber($data['employer']['cpf']);
        }

        if (isset( $data['resident']['rg'])) {
            $data['resident']['rg'] = $this->repository->formatNumber($data['resident']['rg']);
        }

        if (isset( $data['resident']['phone'])) {
            $data['resident']['phone'] = $this->repository->formatNumber($data['resident']['phone']);
        }

        $data['password'] = $this->random_password(10, 'upper');

        if ($user) {
            return ['success' => false, 'message' => 'Já existe email cadastrado!'];
        }

        $this->repository->store($data);
        return ['success' => true, 'message' => 'Cadastrado com sucesso!'];
    }

    /**
     * Summary of upload
     * @param mixed $image
     * @param mixed $id
     * @return JsonResponse|mixed
     */
    public function upload($image, $id = null) {

        $imageName = ($id ? $id : Str::uuid()) . '_image';
        //salva na pasta public
        $path = $image->file('image')->store('public/uploads', $imageName);

        return response()->json([
            'success' => true,
            'path' => Storage::url($path),
        ]);
    }


    /**
     * Summary of update
     * @param array $data
     * @param mixed $id
     * @return JsonResponse|mixed
     */
    public function update(array $data, $id) {

        $data['resident']['cpf'] = $this->repository->formatNumber($data['resident']['cpf']);
        // Log::debug('dados do resident',[$data]);
        if (isset( $data['employer']['cpf'])) {
            $data['employer']['cpf'] = $this->repository->formatNumber($data['employer']['cpf']);
        }

        if (isset( $data['resident']['rg'])) {
            $data['resident']['rg'] = $this->repository->formatNumber($data['resident']['rg']);
        }

        if (isset( $data['resident']['phone'])) {
            $data['resident']['phone'] = $this->repository->formatNumber($data['resident']['phone']);
        }


        $email = $data['resident']['email'];
        $user = $this->repository->getUserByEmail($email);
        $userId = $this->repository->getUserById($user->id);


        $model = $this->findById($id);

        if ($model->user->id !== $userId->id) {

            return response()->json(['success' => false, 'message' => 'Já existe email cadastrado!']);
        }

        return $this->repository->update($model, $data);
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $model = $this->findById($id);
        $this->repository->destroy($model);

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
     * Summary of updateImage
     * @param mixed $request
     * @param mixed $id
     * @return JsonResponse|mixed
     */
    public function updateImage($request, $id)
    {
            // Log::debug('Request all', [$request->all()]);
            // Log::debug('Request file', [$request->all()]);

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $nameImage = $id.'.'.$image->getClientOriginalExtension();

            if (file_exists(env('UPLOAD_IMAGE').$nameImage)) {
                unlink(env('UPLOAD_IMAGE').$nameImage);
            }
            // Log::info('imagem: '.$nameImage);
            $image->storeAs('public/uploads', $nameImage);

            // Retornar o caminho acessível ao navegador
            $publicPath = asset('storage/uploads/' . $nameImage);
            // Log::debug('depois de deletar: '.file_exists(''.$publicPath));
            $data['resident']['url_image'] = $publicPath;
            $model = $this->findById($id);
            // Log::debug('id do morador: '.$model->id);
            $this->repository->update($model, $data);
            // Log::info('Após atualizar');
            return response()->json(['path' => $publicPath,'status' =>  true], 201);

        } else {
            Log::warning('não enviou a imagem');
            return response()->json(['status' => false, 'message' => 'File not uploaded'], 400);

        }
    }


    /**
     * Summary of random_password
     * @param int $length
     * @param string $case
     * @return string
     */
    public function random_password(int $length, string $case = 'both') {

        $alphabets = [
            'lower'=>'abcdefghijklmnopqrstuvwxyz',
            'upper' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'both'  => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        ];
        $pool = $alphabets[$case] ?? $alphabets['both'];

        $out = '';
        $max = strlen($pool) - 1;
        for ($i = 0; $i < $length; $i++) {
            $out .= $pool[random_int(0, $max)];
        }
        return $out;
    }

    public function getPeopleCpf(string $cpf) {

        return $this->peopleService->getPeopleCpf($cpf);
    }

}
