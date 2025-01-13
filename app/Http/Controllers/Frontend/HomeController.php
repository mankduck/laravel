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

        $widgets = [
            // 'new-product' => $this->widgetService->findWidgetByKeyword('new-product', $this->language, ['children' => true])
            'new-product' => $this->widgetService->findWidgetByKeyword('new-product', $this->language, ['children' => true, 'object' => true, 'countObject' => true]),
            'new-shirt' => $this->widgetService->findWidgetByKeyword('new-shirt', $this->language)


        ];

        // dd($widgets['new-product']);

        $slides = $this->slideRepository->findByCondition(...$this->slideAgrument());
        if ($slides) {
            $slideItems = $slides->item[$this->language];
        } else {
            $slideItems = [];
        };

        $system = $this->system;

        $seo = [
            'meta_title' => $system['seo_meta_title'],
            'meta_keyword' => $system['seo_meta_keyword'],
            'meta_description' => $system['seo_meta_description'],
            'canonical' => config('app.url'),
        ];

        return view('frontend.homepage.home.index', compact('slides', 'slideItems', 'widgets', 'seo', 'system'));
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
