<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\EmployeeService;
use App\Http\Request\StoreUpdateEmployeeFormRequest;


class EmployeeController extends CrudController
{
    //
    private $service;
    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateEmployeeFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateEmployeeFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }

    public function storeFormData(StoreUpdateEmployeeFormRequest $request) {
       return $this->service->storeFormData($request);
    }

    public function updateFormData(StoreUpdateEmployeeFormRequest $request, int $id) {
        return $this->service->updateFormData($request, $id);
    }

    public function getPeopleCpf(string $cpf) {
        return $this->service->getPeopleCpf($cpf);
    }

    public function getType() {
        return $this->service->getType();
    }



}
