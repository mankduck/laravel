<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
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
    protected $productService;
    protected $productCatalogueRepository;


    public function __construct(
        WidgetRepository $widgetRepository,
        PromotionRepository $promotionRepository,
        ProductService $productService,
        ProductCatalogueRepository $productCatalogueRepository,
    ) {
        $this->widgetRepository = $widgetRepository;
        $this->promotionRepository = $promotionRepository;
        $this->productService = $productService;
        $this->productCatalogueRepository = $productCatalogueRepository;
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

            if (count($object)) {

                foreach ($object as $key_1 => $value) {
                    if ($model === 'product' && isset($param['object']) && $param['object'] == true) {
                        $productId = $value->products->pluck('id')->toArray();
                        $value->products = $this->productService->comebineProductAndPromotion($productId, $value->products);
                    }

                    if (isset($param['children']) && $param['children'] == true) {
                        $condition = [
                            ['lft', '>', $value->lft],
                            ['rgt', '<', $value->rgt],
                            config('apps.general.defaultPublish')
                        ];
                        $value->childrens = $this->productCatalogueRepository->findByCondition($condition, true);
                    }


                }
            }
            return $object;
        }
        ;
    }


    public function getWidget(array $params = [], $language)
    {
        $whereIn = [];
        $whereInField = 'keyword';
        if (count($params)) {
            foreach ($params as $key => $value) {
                $whereIn[] = $value['keyword'];
            }
        }
        $widgets = $this->widgetRepository->getWidgetByWhereIn($whereIn);

        if (!is_null($widgets)) {
            foreach ($widgets as $key => $widget) {
                $class = loadClass($widget->model);
                $agrument = $this->widgetAgrument($widget, $language, $params[$key]);
                $object = $class->findByCondition(...$agrument);
                $model = lcfirst(str_replace('Catalogue', '', $widget->model));

                if (count($object)) {

                    foreach ($object as $key_1 => $value) {
                        if ($model === 'product' && isset($params['object']) && $params['object'] == true) {
                            $productId = $value->products->pluck('id')->toArray();
                            $value->products = $this->productService->comebineProductAndPromotion($productId, $value->products);
                        }

                        if (isset($params['children']) && $params['children'] == true) {
                            $condition = [
                                ['lft', '>', $value->lft],
                                ['rgt', '<', $value->rgt],
                                config('apps.general.defaultPublish')
                            ];
                            $value->childrens = $this->productCatalogueRepository->findByCondition($condition, true);
                        }


                    }
                }
            }
            dd($object->toArray());
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

        if (strpos($widget->model, 'Catalogue') && isset($param['object'])) {
            $model = lcfirst(str_replace('Catalogue', '', $widget->model)) . 's';
            $relation[$model] = function ($query) use ($param, $language) {
                $limit = ($param['limit']) ?? 9;
                $query->limit($limit);
                $query->where('publish', 2);
                $query->with('languages', function ($query) use ($language) {
                    $query->where('language_id', $language);
                });
            };
            if (isset($param['countObject'])) {
                $withCount[] = $model;
            }
        }
        ;





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
