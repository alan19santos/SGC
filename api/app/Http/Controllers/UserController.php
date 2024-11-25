<?php

namespace App\Http\Controllers;
use App\Http\Request\StoreUpdateUserFormRequest;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use Illuminate\Http\Request;


class UserController extends CrudController
{
    private  $service;


    public function __construct(UserService $service) {
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateUserFormRequest $request): JsonResponse
    {
        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateUserFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }

    public function getProfileUser(int $user_id)
    {
        return $this->service->getProfileUser($user_id);
    }

}
