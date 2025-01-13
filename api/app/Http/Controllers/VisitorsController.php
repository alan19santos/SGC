<?php

namespace App\Http\Controllers;

use App\Services\VisitorsService;
use Illuminate\Http\JsonResponse;
use App\Http\Request\StoreUpdateVisitorsFormRequest;

class VisitorsController extends CrudController
{
    private $service;

    public function __construct(VisitorsService $service)
    {
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateVisitorsFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateVisitorsFormRequest $request, int $id): JsonResponse
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
