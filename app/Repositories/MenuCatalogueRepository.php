<?php

namespace App\Repositories;

use App\Models\MenuCatalogue;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\District;

/**
 * Class DistrictService
 * @package App\Services
 */
class MenuCatalogueRepository extends BaseRepository implements MenuCatalogueRepositoryInterface
{
    protected $model;

    public function __construct(
        MenuCatalogue $model
    ) {
        $this->model = $model;
    }

}
