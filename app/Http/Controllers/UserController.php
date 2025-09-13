<?php

namespace App\Http\Controllers;
use App\Http\Request\StoreUpdateUserFormRequest;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use Illuminate\Http\Request;


class UserController extends CrudController
{
    private  $service;


    /**
     * Summary of __construct
     * @param \App\Services\UserService $service
     */
    public function __construct(UserService $service) {
        $this->service = $service;
        parent::__construct($service);
    }

    /**
     * Summary of beforeStore
     * @param \App\Http\Request\StoreUpdateUserFormRequest $request
     * @return JsonResponse
     */
    protected function beforeStore(StoreUpdateUserFormRequest $request): JsonResponse
    {
        $request->validated();
        return $this->store($request);
    }

    /**
     * Summary of beforeUpdate
     * @param \App\Http\Request\StoreUpdateUserFormRequest $request
     * @param int $id
     * @return JsonResponse
     */
    protected function beforeUpdate(StoreUpdateUserFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    /**
     * Summary of restore
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }

    /**
     * Summary of getProfileUser
     * @param int $user_id
     */
    public function getProfileUser(int $user_id)
    {
        return $this->service->getProfileUser($user_id);
    }

}
