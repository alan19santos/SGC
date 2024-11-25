<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CondominiumService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;
use App\Http\Request\StoreUpdateCondominiumFormRequest;

class CondominiumController extends CrudController
{
    private $service;

    public function __construct(CondominiumService $service)
    {
        $this->service = $service;
        parent::__construct($service);
    }
    protected function beforeStore(StoreUpdateCondominiumFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateCondominiumFormRequest $request, int $id): JsonResponse
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
