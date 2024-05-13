<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    protected $systemRepository;
    protected $slideRepository;
    public function __construct(
        SlideRepository $slideRepository
    ) {
        parent::__construct();
        $this->slideRepository = $slideRepository;
    }
    public function index()
    {
        $language = $this->language;

        $slides = $this->slideRepository->findByCondition(...$this->slideAgrument());
        if ($slides) {
            $slideItems = $slides->item[$this->language];
        }else{
            $slideItems = [];
        }
        ;

        return view('frontend.homepage.home.index', compact('slides', 'slideItems'));
    }

    private function slideAgrument()
    {
        return [
            'condition' => [
                config('apps.general.defaultPublish'),
                ['keyword', '=', 'main-slide']
            ]
        ];
    }
}
