<?php

namespace App\Http\Controllers;
use App\Http\Request\StoreUpdateCompanyFormRequest;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
class CompanyController extends CrudController
{
    private $service;

    /**
     * Summary of __construct
     * @param CompanyService $service
     */
    public function __construct(CompanyService $service){
        $this->service = $service;
        parent::__construct($service);
    }

    /**
     * Summary of beforeStore
     * @param StoreUpdateCompanyFormRequest $request
     * @return JsonResponse
     */
    protected function beforeStore(StoreUpdateCompanyFormRequest $request) {

        $request->validated();
        return $this->store($request);
    }

    /**
     * Summary of beforeUpdate
     * @param StoreUpdateCompanyFormRequest $request
     * @param int $id
     * @return JsonResponse
     */
    protected function beforeUpdate(StoreUpdateCompanyFormRequest $request, int $id): JsonResponse
    {
        $request->validated();
        return $this->update($request, $id);
    }

    /**
     * Summary of restore
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $this->service->restore($id);
        return response()->json(['message' =>'Registro restaurado com sucesso.'], 200);
    }

}
