<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use Illuminate\Http\Request;

class RouterController extends FrontendController
{
    protected $routerRepository;

    public function __construct(
        RouterRepository $routerRepository,
    ) {
        parent::__construct();
        $this->routerRepository = $routerRepository;
    }
    public function index(string $canonical = '') {
        $router = $this->routerRepository->findByCondition([
            ['canonical', '=', $canonical],
            ['language_id', '=', $this->language]
        ]);
        if(!is_null($router) && !empty($router)){
            $method = 'index';
            echo app($router->controllers)->{$method}($router->module_id, $this->language);
        }
    }

    private function slideAgrument() {}
}
