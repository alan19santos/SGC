<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\StoreUpdateApartmentFormRequest;
use App\Services\ApartmentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ApartmentController extends CrudController
{
    private $service;

    public function __construct(ApartmentService $service){
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateApartmentFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateApartmentFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }

    public function getTowerApartment(int $id) {
        return $this->service->getTowerApartment($id);
    }


}
