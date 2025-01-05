<?php

namespace App\Services;

use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Services\Interfaces\WidgetServiceInterface;
use App\Repositories\Interfaces\WidgetRepositoryInterface as WidgetRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class WidgetService
 * @package App\Services
 */
class WidgetService extends BaseService implements WidgetServiceInterface
{
    protected $widgetRepository;
    protected $promotionRepository;


    public function __construct(
        WidgetRepository $widgetRepository,
        PromotionRepository $promotionRepository,
    ) {
        $this->widgetRepository = $widgetRepository;
        $this->promotionRepository = $promotionRepository;
    }



    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $widgets = $this->widgetRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'widget/index'],
        );

        // dd($widgets);


        return $widgets;
    }

    public function create($request, $languageId)
    {
        DB::beginTransaction();
        try {

            $payload = $request->only('name', 'keyword', 'short_code', 'description', 'album', 'model');
            $payload['model_id'] = $request->input('modelItem.id');
            $payload['description'] = [

                $languageId => $payload['description']
            ];
            // dd($payload);
            $widget = $this->widgetRepository->create($payload);
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

            $payload = $request->only('name', 'keyword', 'short_code', 'description', 'album', 'model');
            $payload['model_id'] = $request->input('modelItem.id');
            $payload['description'] = [

                $languageId => $payload['description']
            ];
            $widget = $this->widgetRepository->update($id, $payload);
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
            $widget = $this->widgetRepository->SoftDeletes($id);

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

    public function saveTranslate($request, $languageId)
    {
        DB::beginTransaction();
        try {
            $temp = [];
            $translateId = $request->input('translateId');
            $widget = $this->widgetRepository->findById($request->input('widgetId'));
            $temp = $widget->description;
            $temp[$translateId] = $request->input('translate_description');
            $payload['description'] = $temp;
            $widget = $this->widgetRepository->update($widget->id, $payload);

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

    public function findWidgetByKeyword($keyword = '', $language = 1, $param = [])
    {
        $widget = $this->widgetRepository->findByCondition([
            ['keyword', '=', $keyword],
            config('apps.general.defaultPublish')
        ]);

        if (!is_null($widget)) {
            $class = loadClass($widget->model);
            $agrument = $this->widgetAgrument($widget, $language, $param);
            $object = $class->findByCondition(...$agrument);

            $model = lcfirst(str_replace('Catalogue', '', $widget->model));
            if ($model == 'product') {
                if (count($object)) {
                    foreach ($object as $key_1 => $value) {
                        if ($value->id != 4) continue;
                        $productId = $value->products->pluck('id');
                        // dd($productId);
                        $promotions = $this->promotionRepository->findByProduct($productId);
                        // dd($promotions);
                        if ($promotions) {
                            foreach ($value->products as $index => $product) {
                                foreach ($promotions as $key => $promotion) {
                                    // dd($promotion);
                                    if ($promotion->product_id == $product->id) {
                                        $object[$key_1]->products[$index]->promotions = $promotion;
                                    }
                                }
                            }
                        }
                    }
                }
            }
// dd($object->toArray());
            return $object;
        }
    }

    private function widgetAgrument($widget, $language, $param)
    {

        $relation = [
            'languages' => function ($query) use ($language) {
                $query->where('language_id', $language);
            }
        ];

        $withCount = [];

        if (strpos($widget->model, 'Catalogue') && isset($param['children'])) {
            $model = lcfirst(str_replace('Catalogue', '', $widget->model)) . 's';
            $relation[$model] = function ($query) use ($param, $language) {
                $limit = ($param['limit']) ?? 9;
                $query->limit($limit);
                $query->where('publish', 2);
                $query->with('languages', function ($query) use ($language) {
                    $query->where('language_id', $language);
                });
            };

            // $query->with('promotions', function ($query) {
            //     $query->select(
            //         'promotions.id',
            //         'promotions.discountType',
            //         'promotions.discountValue',
            //         'promotions.maxDiscountValue',
            //         DB::raw(
            //             "
            //             IF(
            //                 promotions.maxDiscountValue != 0,
            //                 LEAST(
            //                 CASE
            //                     WHEN promotions.discountType = 'cash' THEN (SELECT price FROM products WHERE products.id = product_id) - promotions.discountValue
            //                     WHEN promotions.discountType = 'percent' THEN (SELECT price FROM products WHERE products.id = product_id) - ((SELECT price FROM products WHERE products.id = product_id)*promotions.discountValue/100)
            //                     ELSE (SELECT price FROM products WHERE products.id = product_id)
            //                 END,
            //                 promotions.maxDiscountValue
            //                 ),
            //                 CASE
            //                     WHEN discountType = 'cash' THEN (SELECT price FROM products WHERE products.id = product_id) - promotions.discountValue
            //                     WHEN discountType = 'percent' THEN (SELECT price FROM products WHERE products.id = product_id) - ((SELECT price FROM products WHERE products.id = product_id)*promotions.discountValue/100)
            //                     ELSE (SELECT price FROM products WHERE products.id = product_id)
            //                 END
            //             )as discount
            //             "
            //         )
            //     );
            //     $query->where('publish', 2);
            //     $query->whereDate('endDate', '>', now());
            //     $query->orderBy('discount', 'asc');
            // });
            $withCount[] = $model;
        };





        return [
            'condition' => [
                config('apps.general.defaultPublish')
            ],
            'flag' => true,
            'relation' => $relation,
            'param' => [
                'whereIn' => $widget->model_id,
                'whereInField' => 'id'
            ],
            'withCount' => $withCount
        ];
    }

    private function paginateSelect()
    {
        return [
            'id',
            'keyword',
            'short_code',
            'description',
            'name',
            'publish'
        ];
    }
}
