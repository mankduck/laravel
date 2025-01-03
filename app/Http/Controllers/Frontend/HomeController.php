<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
use App\Services\Interfaces\WidgetServiceInterface as WidgetService;
use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    protected $systemRepository;
    protected $slideRepository;
    protected $widgetService;



    public function __construct(
        SlideRepository $slideRepository,
        WidgetService $widgetService
    ) {
        parent::__construct();
        $this->slideRepository = $slideRepository;
        $this->widgetService = $widgetService;
    }
    public function index()
    {
        $language = $this->language;

        $widget = [
            'new-product' => $this->widgetService->findWidgetByKeyword('new-product', $this->language, ['children' => true])
        ];

        $slides = $this->slideRepository->findByCondition(...$this->slideAgrument());
        if ($slides) {
            $slideItems = $slides->item[$this->language];
        } else {
            $slideItems = [];
        };

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
