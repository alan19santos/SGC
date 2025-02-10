<?php

namespace App\Http\Controllers;

use App\Services\SpaceReservationService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use App\Http\Request\StoreUpdateSpaceReservationFormRequest;

class SpaceReservationController extends CrudController
{
    private $service;

    public function __construct(SpaceReservationService $service){
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateSpaceReservationFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateSpaceReservationFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }

    public function typeReserved() {
        return $this->service->typeReserved();
    }
    


}
