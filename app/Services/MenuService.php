<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use App\Services\Interfaces\MenuServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class MenuService
 * @package App\Services
 */
class MenuService extends BaseService implements MenuServiceInterface
{
    protected $menuRepository;
    protected $menuCatalogueRepository;
    protected $routerRepository;
    protected $nestedset;

    public function __construct(
        MenuRepository $menuRepository,
        MenuCatalogueRepository $menuCatalogueRepository,
        RouterRepository $routerRepository,
    ) {
        $this->menuRepository = $menuRepository;
        $this->menuCatalogueRepository = $menuCatalogueRepository;
        $this->routerRepository = $routerRepository;
        $this->controllerName = 'MenuController';
    }


    private function initialize($languageId)
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'menus',
            'foreignkey' => 'menu_id',
            'isMenu' => TRUE,
            'language_id' => $languageId,
        ]);
    }

    public function paginate($request, $languageId)
    {
        return [];
    }

    public function save($request, $languageId)
    {
        DB::beginTransaction();
        try {

            $payload = $request->only('menu', 'menu_catalogue_id');
            $menuArray = [];
            if (isset($payload['menu']['name'])) {
                foreach ($payload['menu']['name'] as $key => $val) {
                    $menuId = $payload['menu']['id'][$key];
                    $menuArray = [
                        'menu_catalogue_id' => $payload['menu_catalogue_id'],
                        'order' => $payload['menu']['order'][$key],
                        'user_id' => Auth::id(),
                    ];

                    if ($menuId == 0) {
                        $menu = $this->menuRepository->create($menuArray);
                    } else {
                        $menu = $this->menuRepository->update($menuId, $menuArray);

                        if ($menu->rgt - $menu->lft > 1) {
                            $this->menuRepository->updateByWhere(
                                [
                                    ['lft', '>', $menu->lft],
                                    ['rgt', '<', $menu->rgt],
                                ],
                                ['menu_catalogue_id' => $payload['menu_catalogue_id']],
                            );
                        }
                    }

                    // dd($menuArray);
                    if ($menu->id > 0) {
                        $menu->languages()->detach([$languageId, $menu->id]);
                        // dd($menu); die;
                        $payloadLanguage = [
                            'language_id' => $languageId,
                            'name' => $val,
                            'canonical' => $payload['menu']['canonical'][$key]
                        ];


                        $this->menuRepository->createPivot($menu, $payloadLanguage, 'languages');
                    }
                    
                }

                $this->initialize($languageId);
                $this->nestedset();
            }
            // dd(1);
            // echo 1;
            // die();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }


    public function saveChildren($request, $languageId, $menu)
    {
        DB::beginTransaction();
        try {

            $payload = $request->only('menu');
            // dd($payload);   
            if (count($payload['menu']['name'])) {
                foreach ($payload['menu']['name'] as $key => $val) {
                    $menuId = $payload['menu']['id'][$key];
                    $menuArray = [
                        'menu_catalogue_id' => $menu->menu_catalogue_id,
                        'parent_id' => $menu->id,
                        'order' => $payload['menu']['order'][$key],
                        'user_id' => Auth::id(),
                    ];
                    $menu = ($menuId == 0) ? $this->menuRepository->create($menuArray) : $this->menuRepository->update($menuId, $menuArray);
                    if ($menu->id > 0) {
                        $menu->languages()->detach([$languageId, $menu->id]);
                        $payloadLanguage = [
                            'language_id' => $languageId,
                            'name' => $val,
                            'canonical' => $payload['menu']['canonical'][$key]
                        ];
                        $this->menuRepository->createPivot($menu, $payloadLanguage, 'languages');

                    }
                }
                $this->initialize($languageId);
                $this->nestedset();
            }
            // dd(1);
            // echo 1;
            // die();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }


    public function dragUpdate(array $json = [], int $menuCatalogueId = 0, int $languageId = 1, $parentId = 0)
    {
        if (count($json)) {
            foreach ($json as $key => $val) {
                $update = [
                    'order' => count($json) - $key,
                    'parent_id' => $parentId,
                ];
                $menu = $this->menuRepository->update($val['id'], $update);
                if (isset($val['children']) && count($val['children'])) {
                    $this->dragUpdate($val['children'], $menuCatalogueId, $languageId, $val['id']);
                }
            }
        }
        $this->initialize($languageId);
        $this->nestedset();
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->menuRepository->forceDeleteByCondition([
                ['menu_catalogue_id', '=', $id]
            ]);

            $this->menuCatalogueRepository->forceDelete($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }


    public function getAndConvertMenu($menu = null, $language = 1): array
    {
        $menuList = $this->menuRepository->findByCondition([
            ['parent_id', '=', $menu->id]
        ], TRUE, [
            'languages' => function ($query) use ($language) {
                $query->where('language_id', $language);
            }
        ]);
        return $this->convertMenu($menuList);
    }


    public function convertMenu($menuList = null)
    {
        $temp = [];
        $fields = ['name', 'canonical', 'order', 'id'];
        if (count($menuList)) {
            foreach ($menuList as $key => $val) {
                foreach ($fields as $field) {
                    if ($field == 'name' || $field == 'canonical') {
                        $temp[$field][] = $val->languages->first()->pivot->{$field};
                    } else {
                        $temp[$field][] = $val->{$field};

                    }
                }
            }
        }
        return $temp;

    }



    public function findMenuItemTranslate($menus, int $currentLanguage = 1, int $languageId = 1)
    {
        $output = [];
        if (count($menus)) {
            foreach ($menus as $key => $menu) {
                $canonical = $menu->languages->first()->pivot->canonical;
                $detailMenu = $this->menuRepository->findById($menu->id, ['*'], [
                    'languages' => function ($query) use ($languageId) {
                        $query->where('language_id', $languageId);
                    }
                ]);
                if ($detailMenu) {
                    if ($detailMenu->languages->isNotEmpty()) {
                        $menu->translate_name = $detailMenu->languages->first()->pivot->name;
                        $menu->translate_canonical = $detailMenu->languages->first()->pivot->canonical;
                    } else {
                        $router = $this->routerRepository->findByCondition([
                            ['canonical', '=', $canonical]
                        ]);
                        if ($router) {
                            $controller = explode('\\', $router->controllers);
                            $model = str_replace('Controller', '', end($controller));
                            $serviceInterfaceNamespace = '\App\Repositories\\' . $model . 'Repository';
                            if (class_exists($serviceInterfaceNamespace)) {
                                $serviceInstance = app($serviceInterfaceNamespace);
                            }
                            $alias = Str::snake($model) . '_language';
                            $object = $serviceInstance->findByWhereHas([
                                'canonical' => $canonical,
                                'language_id' => $currentLanguage
                            ], 'languages', $alias);
                            if ($object) {
                                $translateObject = $object->languages()->where('language_id', $languageId)->first([$alias . '.name', $alias . '.canonical']);
                                if (!is_null($translateObject)) {
                                    $menu->translate_name = $translateObject->name;
                                    $menu->translate_canonical = $translateObject->canonical;
                                }
                            }
                        }
                    }
                }
                $output[] = $menu;
            }
        }
        return $output;
    }



    public function saveTranslateMenu($request, int $languageId = 1)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only('translate');
            if (count($payload['translate']['name'])) {
                foreach ($payload['translate']['name'] as $key => $val) {
                    if ($val == null)
                        continue;

                    $temp = [
                        'language_id' => $languageId,
                        'name' => $val,
                        'canonical' => $payload['translate']['canonical'][$key]
                    ];

                    $menu = $this->menuRepository->findById($payload['translate']['id'][$key]);
                    $menu->languages()->detach($languageId);
                    $this->menuRepository->createPivot($menu, $temp, 'languages');
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }
}
