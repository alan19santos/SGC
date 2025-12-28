<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TypeServiceService;
use Illuminate\Http\Request;

class TypeServiceController extends CrudController
{
    private $service;

    public function __construct(TypeServiceService $service) {
        $this->service = $service;
        parent::__construct($service);
    }


}
