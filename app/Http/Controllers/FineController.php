<?php

namespace App\Http\Controllers;
use App\Services\FineService;

class FineController extends CrudController
{
    private $service;
    public function __construct(FineService $service){
        $this->service = $service;
        parent::__construct($service);
    }

    /**
     * Summary of getAll
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll() {
        return $this->service->getAll();
    }

    /**
     * Summary of findById
     * @param int $id
     * @return object
     */
    public function findById(int $id) {
        return $this->service->findById($id);
    }

}
