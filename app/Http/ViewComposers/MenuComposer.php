<?php

namespace App\Http\ViewComposers;

use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;
use Illuminate\View\View;

class MenuComposer
{
    protected $language;
    protected $menuCatalogueRepository;
    public function __construct(
        MenuCatalogueRepository $menuCatalogueRepository,
        $language
    ) {
        $this->menuCatalogueRepository = $menuCatalogueRepository;
        $this->language = $language;
    }
    public function compose(View $view)
    {

        $language = $this->language;
        $menuCatalogue = $this->menuCatalogueRepository->findByCondition([
            ['keyword', '=', 'menu-chinh']
        ], FALSE, [
            'menus' => function ($query) use ($language) {
                $query->with([
                    'languages' => function ($query) use ($language) {
                        $query->where('language_id', $language);
                    }
                ]);
            }
        ]);
        $menus = frontend_recursive_menu(recursive($menuCatalogue->menus));

        $view->with('menu', $menus);
    }

    // private function agrument($language){
    //     return [
    //         'condition' => [
    //             ['keyword', '=', 'main-menu']
    //         ]
    //     ]
    // }
}