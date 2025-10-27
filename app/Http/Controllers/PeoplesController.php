<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PeoplesServices;
use App\Http\Request\StoreUpdatePeoplesFormRequest;


class PeoplesController extends CrudController
{
    //
    private $service;

    public function __construct(PeoplesServices $service)
    {
        $this->service = $service;
        parent::__construct($service);
    }


    protected function beforeStore(StoreUpdatePeoplesFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdatePeoplesFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }

    public function storeFormData(Request $request) {
        $this->service->storeFormData($request);
    }

    public function updateFormData(Request $request, int $id) {
        $this->service->updateFormData($request, $id);
    }

    public function getPeopleCpf(string $cpf) {
        return $this->service->getPeopleCpf($cpf);
    }

}
