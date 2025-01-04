<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TowerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Request\StoreUpdateTowerFormRequest;


class TowerController extends CrudController
{

    private $service;

    public function __construct(TowerService $service)
    {
        $this->service = $service;
        parent::__construct($service);
    }
    protected function beforeStore(StoreUpdateTowerFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateTowerFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }

    public function getTowerCondominium($id) {
        return $this->service->getTowerCondominium($id);
    }
}
