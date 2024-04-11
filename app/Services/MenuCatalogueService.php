<?php

namespace App\Services;

use App\Services\Interfaces\MenuCatalogueServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class MenuCatalogueService
 * @package App\Services
 */
class MenuCatalogueService extends BaseService implements MenuCatalogueServiceInterface
{
    protected $menuCatalogueRepository;

    public function __construct(
        MenuCatalogueRepository $menuCatalogueRepository,
    ) {
        $this->menuCatalogueRepository = $menuCatalogueRepository;
        $this->controllerName = 'MenuCatalogueController';
    }

    public function paginate($request, $languageId)
    {
        return [];
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only('name', 'keyword');
            $payload['keyword'] = Str::slug($payload['keyword']);
            $menuCatalogue = $this->menuCatalogueRepository->create($payload);
            DB::commit();
            return [
                'flag' => TRUE,
                'title' => $menuCatalogue->name,
                'id' => $menuCatalogue
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
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
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }


    private function paginateSelect()
    {
        return [
            'menuCatalogues.id',
            'menuCatalogues.publish',
            'menuCatalogues.image',
            'menuCatalogues.order',
            'tb2.name',
            'tb2.canonical',
        ];
    }


}
