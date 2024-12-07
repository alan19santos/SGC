<?php

namespace App\Services;
use App\Repositories\Core\ResidentRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ResidentService {
    private $repository;
    public function __construct(ResidentRepository $repository)
    {
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

    public function store(array $data) {

        $email = $data['resident']['email'];

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

        if ($user) {
            return ['success' => false, 'message' => 'Já existe email cadastrado!'];
        }
        
        $this->repository->store($data);
    }

    public function upload($image, $id = null) {

        $imageName = ($id ? $id : Str::uuid()) . '_image';
        //salva na pasta public
        $path = $image->file('image')->store('public/uploads', $imageName);

        return response()->json([
            'success' => true,
            'path' => Storage::url($path),
        ]);
    }

    public function update(array $data, $id) {      
       
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


        $email = $data['resident']['email'];
        $user = $this->repository->getUserByEmail($email);
        $userId = $this->repository->getUserById($user->id);        
        

        $model = $this->findById($id);

        if ($model->user->id !== $userId->id) {
            
            return response()->json(['success' => false, 'message' => 'Já existe email cadastrado!']);
        }

        return $this->repository->update($model, $data);
    }

    public function destroy(int $id): void
    {
        $model = $this->findById($id);
        $this->repository->destroy($model);

    }

    public function restore(int $id): void
    {
        $this->repository->restore($id);
    }

    public function updateImage($request, $id)
    {
            
        if ($request->hasFile('image')) 
        {           
            $image = $request->file('image');
            $nameImage = $id.'.'.$image->getClientOriginalExtension();
            $image->storeAs('public/uploads', $nameImage);

            // Retornar o caminho acessível ao navegador
            $publicPath = asset('storage/uploads/' . $nameImage);
    
            return response()->json(['path' => $publicPath], 201);

        }
        return response()->json(['status' => false, 'message' => 'File not uploaded'], 400);
    }
}
