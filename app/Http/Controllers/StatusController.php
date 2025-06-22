<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\StatusService;
use App\Http\Request\StoreUpdateStatusFormRequest;

class StatusController extends CrudController
{
    //
    private $service;

    public function __construct(StatusService $service)
    {
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateStatusFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateStatusFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }


}
