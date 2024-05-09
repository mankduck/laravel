<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    protected $systemRepository;
    public function __construct(
    ) {
        parent::__construct();
    }
    public function index()
    {
        $language = $this->language;
        return view('frontend.homepage.home.index');
    }
}
