<?php

namespace App\Services;

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
        dd(123123);
        DB::beginTransaction();
        try {

            $payload = $request->only('name', 'keyword', 'short_code', 'description', 'album', 'model');
            $payload['model_id'] = $request->input('modelItem.id');
            $payload['description'] = [

                $languageId => $payload['description']
            ];
            // dd($payload);
            $promotion = $this->promotionRepository->create($payload);
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
            $payload ['description'] = $temp;
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
