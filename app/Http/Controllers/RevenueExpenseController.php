<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RevenueExpenseService;
use App\Http\Request\StoreUpdateRevenueExpenseFormRequest;

class RevenueExpenseController extends CrudController
{
    //
     private $service;
    public function __construct(RevenueExpenseService $service)
    {
        $this->service = $service;
        parent::__construct($service);
    }

    protected function beforeStore(StoreUpdateRevenueExpenseFormRequest $request)
    {
        $request->validated();
        return $this->store($request);
    }

    protected function beforeUpdate(StoreUpdateRevenueExpenseFormRequest $request, int $id)
    {
        $request->validated();
        return $this->service->update($request->all(), $id);
    }


    public function getFinancialCategories()
    {
        return $this->service->getCategories();

    }

    public function getTypeRevenueExpense()
    {
        return $this->service->getTypes();
    }


}
