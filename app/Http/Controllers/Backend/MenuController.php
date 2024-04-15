<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChildrenRequest;
use App\Models\Language;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;
use App\Services\Interfaces\MenuCatalogueServiceInterface as MenuCatalogueService;
use Illuminate\Http\Request;

use App\Services\Interfaces\MenuServiceInterface as MenuService;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;

class MenuController extends Controller
{
    protected $menuService;
    protected $menuCatalogueService;

    protected $menuRepository;
    protected $menuCatalogueRepository;

    public function __construct(
        MenuService $menuService,
        MenuCatalogueService $menuCatalogueService,
        MenuRepository $menuRepository,
        MenuCatalogueRepository $menuCatalogueRepository
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });

        $this->menuService = $menuService;
        $this->menuCatalogueService = $menuCatalogueService;
        $this->menuRepository = $menuRepository;
        $this->menuCatalogueRepository = $menuCatalogueRepository;
    }
    public function index(Request $request)
    {
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/library.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'MenuCatalogue'
        ];

        $menuCatalogues = $this->menuCatalogueService->paginate($request, $this->language);
        // dd($menus);
        $config['seo'] = __('messages.menu');

        return view('backend.menu.menu.index', compact('config', 'menuCatalogues'));
    }

    public function create()
    {
        // $this->authorize('modules', 'menu.create');
        $menuCatalogues = $this->menuCatalogueRepository->all();
        $config = $this->config();
        $config['seo'] = __('messages.menu');
        $config['method'] = 'create';
        return view(
            'backend.menu.menu.create',
            compact(
                'config',
                'menuCatalogues'
            )
        );
    }

    public function store(StoreMenuRequest $request)
    {
        if ($this->menuService->create($request, $this->language)) {
            return redirect()->route('menu.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'menu.edit');
        $language = $this->language;
        $menus = $this->menuRepository->findByCondition([
            ['menu_catalogue_id', '=', $id]
        ], TRUE, [
            'languages' => function ($query) use ($language) {
                $query->where('language_id', $language);
            }
        ]);
        // dd($menus);
        // $provinces = $this->provinceRepository->all();
        $config = $this->config();
        $config['seo'] = __('messages.menu');
        $config['method'] = 'show';
        return view(
            'backend.menu.menu.show',
            compact(
                'config',
                'menus'
            )
        );
    }

    public function update($id, UpdateMenuRequest $request)
    {
        if ($this->menuService->update($id, $request)) {
            return redirect()->route('menu.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'menu.delete');
        $config['seo'] = __('messages.menu');
        $menu = $this->menuRepository->findById($id);
        return view(
            'backend.menu.menu.delete',
            compact(
                'menu',
                'config',
            )
        );
    }

    public function destroy($id)
    {
        if ($this->menuService->destroy($id)) {
            return redirect()->route('menu.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }


    public function children($id)
    {
        $language = $this->language;
        $menu = $this->menuRepository->findById($id, ['*'], [
            'languages' => function ($query) use ($language) {
                $query->where('language_id', $language);
            }
        ]);

        $menuList = $this->menuService->getAndConvertMenu($menu, $language);
        // dd($menuList);
        $config = $this->config();
        $config['seo'] = __('messages.menu');
        $config['method'] = 'children';
        return view(
            'backend.menu.menu.children',
            compact(
                'config',
                'menu',
                'menuList'
            )
        );
    }


    public function saveChildren(StoreChildrenRequest $request, $id)
    {
        $menu = $this->menuRepository->findById($id);
        if ($this->menuService->saveChildren($request, $this->language, $menu)) {
            return redirect()->route('menu.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }



    private function config()
    {
        return [

            'js' => [
                'backend/js/plugins/nestable/jquery.nestable.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/menu.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/library.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
        ];
    }
}
