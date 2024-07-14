<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuCatalogueRequest;
use App\Services\Interfaces\MenuCatalogueServiceInterface as MenuCatalogueService;
use App\Services\Interfaces\MenuServiceInterface as MenuService;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use App\Models\Language;


class MenuController extends Controller
{
    protected $menuRepository;
    protected $menuCatalogueService;
    protected $menuService;
    protected $language;

    public function __construct(
        MenuRepository $menuRepository,
        MenuCatalogueService $menuCatalogueService,
        MenuService $menuService
    ) {
        $this->menuRepository = $menuRepository;
        $this->menuCatalogueService = $menuCatalogueService;
        $this->menuService = $menuService;

        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request); 
        });
    }

    public function createCatalogue(StoreMenuCatalogueRequest $request)
    {
        $menuCatalogue = $this->menuCatalogueService->create($request);
        if ($menuCatalogue !== FALSE) {
            return response()->json([
                'code' => 0,
                'message' => 'Tạo bản ghi thành công!',
                'data' => $menuCatalogue
            ]);
        }
        return response()->json([

            'code' => 1,
            'message' => 'Có vấn đề xảy ra, hãy thử lại!',
        ]);
    }

    public function drag(Request $request)
    {
        $json = json_decode($request->string('json'), TRUE);
        $menuCatalogueId = $request->integer('menu_catalogue_id');
        $flag = $this->menuService->dragUpdate($json, $menuCatalogueId, $this->language);
    }
}
