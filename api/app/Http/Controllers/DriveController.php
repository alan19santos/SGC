<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\DriveService;
use App\Http\Request\StoreUpdateDriveFormRequest;

class DriveController extends CrudController
{
    //
    private $service;

    public function __construct(DriveService $service)
    {
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateDriveFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateDriveFormRequest $request, int $id): JsonResponse
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
