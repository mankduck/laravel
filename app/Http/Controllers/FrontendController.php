<?php

namespace App\Http\Controllers;

// use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\System;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    protected $language;
    protected $system;

    public function __construct(
    )
    {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;

            $this->system = convert_array(System::where('language_id', $this->language)->get(), 'keyword', 'content');
            return $next($request);
        });
    }

}
