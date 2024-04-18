<?php

namespace App\Repositories;

use App\Models\Slide;
use App\Repositories\Interfaces\SlideRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class SlideRepository extends BaseRepository implements SlideRepositoryInterface
{
    protected $model;

    public function __construct(
        Slide $model
    ) {
        $this->model = $model;
    }



    // public function getProductById(int $id = 0, $language_id = 0)
    // {
    //     return $this->model->select(
    //         [
    //             'products.id',
    //             'products.product_catalogue_id',
    //             'products.image',
    //             'products.icon',
    //             'products.album',
    //             'products.publish',
    //             'products.follow',
    //             'products.price',
    //             'products.code',
    //             'products.made_in',
    //             'products.attributeCatalogue',
    //             'products.attribute',
    //             'products.variant',
    //             'tb2.name',
    //             'tb2.description',
    //             'tb2.content',
    //             'tb2.meta_title',
    //             'tb2.meta_keyword',
    //             'tb2.meta_description',
    //             'tb2.canonical',
    //         ]
    //     )
    //         ->join('product_language as tb2', 'tb2.product_id', '=', 'products.id')
    //         ->with([
    //             'product_catalogues',
    //             'product_variants' => function ($query) use ($language_id) {
    //                 $query->with([
    //                     'attributes' => function ($query) use ($language_id) {
    //                         $query->with([
    //                             'attribute_language' => function ($query) use ($language_id) {
    //                                 $query->where('language_id', '=', $language_id);
    //                             }
    //                         ]);
    //                     }
    //                 ]);
    //             }
    //         ])
    //         ->where('tb2.language_id', '=', $language_id)
    //         ->find($id);
    // }

}
