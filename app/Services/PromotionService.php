<?php

namespace App\Services;

use App\Enums\PromotionEnum;
use App\Services\Interfaces\PromotionServiceInterface;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class PromotionService
 * @package App\Services
 */
class PromotionService extends BaseService implements PromotionServiceInterface
{
    protected $promotionRepository;


    public function __construct(
        PromotionRepository $promotionRepository
    ) {
        $this->promotionRepository = $promotionRepository;
    }



    public function paginate($request, $languageId)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $promotions = $this->promotionRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'promotion/index'],
        );

        // dd($promotions);


        return $promotions;
    }

    public function create($request, $languageId)
    {
        DB::beginTransaction();
        try {

            $payload = $request->only(
                'name',
                'code',
                'description',
                'method',
                'startDate',
                'endDate',
                'neverEndDate'
            );

            switch ($payload['method']) {
                case PromotionEnum::ORDER_AMOUNT_RANGE:
                    $payload[PromotionEnum::DISCOUNT_INFORMATION] = $this->orderAmountRange($request);
                    break;
                case PromotionEnum::PRODUCT_AND_QUANTITY:
                    $payload[PromotionEnum::DISCOUNT_INFORMATION] = $this->productAndQuantity($request);
                    break;
            }

            $promotion = $this->promotionRepository->create($payload);

            if ($promotion->id > 0) {
                if ($request->input('method') === PromotionEnum::PRODUCT_AND_QUANTITY) {
                    $this->createPromotionProductVariant($request, $promotion);
                }
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

    private function createPromotionProductVariant($request, $promotion)
    {
        $object = $request->input('object');
        $payloadRelation = [];
        foreach ($object['id'] as $key => $value) {
            $payloadRelation[] = [
                'product_id' => $value,
                'product_variant_id' => $object['product_variant_id'][$key],
                'model' => $request->input(PromotionEnum::MODULE_TYPE)
            ];
        }
        $promotion->products()->sync($payloadRelation);
    }

    private function handleSourceAndCondition($request)
    {
        $data = [
            'source' => [
                'status' => $request->input('source'),
                'data' => $request->input('sourceValue'),
            ],
            'apply' => [
                'status' => $request->input('applyStatus'),
                'data' => $request->input('applyValue'),
            ]
        ];
        foreach ($data['apply']['data'] as $key => $value) {
            $data['apply']['condition'][$value] = $request->input($value);
        }
        return $data;
    }


    private function orderAmountRange($request)
    {
        $data['info'] = $request->input('promotion_order_amount_range');

        return $data + $this->handleSourceAndCondition($request);
    }

    private function productAndQuantity($request)
    {
        $data['info'] = $request->input('product_and_quantity');
        $data['info']['model'] = $request->input(PromotionEnum::MODULE_TYPE);
        $data['info']['object'] = $request->input('object');

        return $data + $this->handleSourceAndCondition($request);
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
            $promotion = $this->promotionRepository->update($id, $payload);
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
            $promotion = $this->promotionRepository->SoftDeletes($id);

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
            $promotion = $this->promotionRepository->findById($request->input('promotionId'));
            $temp = $promotion->description;
            $temp[$translateId] = $request->input('translate_description');
            $payload['description'] = $temp;
            $promotion = $this->promotionRepository->update($promotion->id, $payload);

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
