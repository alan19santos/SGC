<?php

namespace App\Http\Controllers;
use App\Services\ProfileService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends CrudController
{
    private $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
        parent::__construct($service);
        
    }
    public function filterSlug(string $slug) {
        $this->service->filterSlug($slug);
    }
}
