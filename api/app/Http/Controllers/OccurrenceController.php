<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\OccurrentService;
use Illuminate\Http\JsonResponse;
use App\Http\Request\StoreUpdateOccurrentFormRequest;
use Illuminate\Http\Request;

class OccurrenceController extends CrudController
{
    //
    private $service;

    public function __construct(OccurrentService $service)
    {
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateOccurrentFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateOccurrentFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }


    public function typeOccurrence() {
        return $this->service->typeOccurrence();
    }

    public function storeHistoric(Request $request) {
        return $this->service->storeHistoric($request->all());
    }

}
