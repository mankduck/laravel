<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\MenuServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/**
 * Class MenuService
 * @package App\Services
 */
class MenuService extends BaseService implements MenuServiceInterface
{
    protected $menuRepository;
    protected $nestedset;

    public function __construct(
        MenuRepository $menuRepository,
    ) {
        $this->menuRepository = $menuRepository;
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

    public function create($request, $languageId)
    {
        DB::beginTransaction();
        try {

            $payload = $request->only('menu', 'menu_catalogue_id', 'type');
            $menuArray = [];
            if (isset($payload['menu']['name'])) {
                foreach ($payload['menu']['name'] as $key => $val) {
                    $menuArray = [

                        'menu_catalogue_id' => $payload['menu_catalogue_id'],
                        'type' => $payload['type'],
                        'order' => $payload['menu']['order'][$key],
                        'user_id' => Auth::id(),
                    ];

                    // dd($menuArray);
                    $menu = $this->menuRepository->create($menuArray);
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
                // dd($menu);

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
                // dd($menu);

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

    public function update($id, $request, $languageId)
    {
        DB::beginTransaction();
        try {
            $menu = $this->menuRepository->findById($id);
            if ($this->uploadMenu($menu, $request)) {
                $this->updateLanguageForMenu($menu, $request, $languageId);
                $this->updateCatalogueForMenu($menu, $request);
                $this->updateRouter(
                    $menu,
                    $request,
                    $this->controllerName,
                    $languageId
                );
            }
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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $menu = $this->menuRepository->delete($id);

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


    private function paginateSelect()
    {
        return [
            'menus.id',
            'menus.publish',
            'menus.image',
            'menus.order',
            'tb2.name',
            'tb2.canonical',
        ];
    }

    private function payload()
    {
        return [
            'menu_catalogue_id',
            'follow',
            'publish',
            'image',
            'album',
            'menu_catalogue_id',
        ];
    }

    private function payloadLanguage()
    {
        return [
            'name',
            'description',
            'content',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'canonical'
        ];
    }


}
