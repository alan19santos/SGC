<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\StoreUpdateUserFormRequest;
use App\Services\ResidentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Request\StoreUpdateResidentFormRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class ResidentController extends CrudController
{
    //
    private $service;

    public function __construct(ResidentService $service) 
    {
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateResidentFormRequest $request): JsonResource
    {
        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateResidentFormRequest $request, int $id): JsonResponse
    {
        $request->validated();        
        return $this->service->update($request->all(), $id);
    }

    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }

    public function updateImage(Request $request, int $id) {

        return $this->service->updateImage($request, $id);
    }

    public function getImageUsers($id) {
        
        $find = $this->service->findById($id);
        // $url =  "storage/uploads/{$id}.png";
        $url =  $find->url_image;

        return response()->json($url);
    }
}
