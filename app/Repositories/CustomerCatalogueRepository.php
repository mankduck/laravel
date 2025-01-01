<?php

namespace App\Repositories;

use App\Models\CustomerCatalogue;
use App\Repositories\Interfaces\CustomerCatalogueRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class CustomerCatalogueRepository extends BaseRepository implements CustomerCatalogueRepositoryInterface
{
    protected $model;

    public function __construct(
        CustomerCatalogue $model
    ) {
        $this->model = $model;
    }

    public function userCataloguePagination(
        array $column = ['*'],
        array $condition = [],
        int $perPage = 1,
        array $extend = [],
        array $orderBy = ['id', 'DESC'],
        array $join = [],
        array $relations = [],
    ) {

        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%');
            }
            if (isset($condition['publish']) && $condition['publish'] != 0) {
                $query->where('publish', '=', $condition['publish']);
            }
            return $query;
        });
        if (!empty($join)) {
            $query->join(...$join);
        }

        return $query->paginate($perPage)
            ->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }

}
