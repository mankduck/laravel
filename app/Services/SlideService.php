<?php

namespace App\Services;

use App\Services\Interfaces\SlideServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class ProductService
 * @package App\Services
 */
class SlideService extends BaseService implements SlideServiceInterface
{
    protected $slideRepository;
    protected $routerRepository;

    public function __construct(
        SlideRepository $slideRepository,
        RouterRepository $routerRepository,
    ) {
        $this->slideRepository = $slideRepository;
        $this->routerRepository = $routerRepository;
        $this->controllerName = 'ProductController';
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $slides = $this->slideRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'slide/index'],
        );

        // dd($users);


        return $slides;
    }

    public function create($request, $languageId)
    {
        DB::beginTransaction();
        try {

            $payload = $request->only(['_token', 'name', 'keyword', 'setting', 'short_code']);
            // $payload['setting'] = $this->formatJson($request, 'setting');
            $payload['item'] = $this->handleSlideItem($request, $languageId);

            $slide = $this->slideRepository->create($payload);

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
            $slide = $this->slideRepository->findById($id);
            $slideItem = $slide->item;

            unset($slideItem[$languageId]);
            $payload = $request->only(['_token', 'name', 'keyword', 'setting', 'short_code']);
            $payload['item'] = $this->handleSlideItem($request, $languageId) + $slideItem;
            // dd($payload);
            $slide = $this->slideRepository->update($id, $payload);
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
            $product = $this->productRepository->delete($id);
            $this->routerRepository->forceDeleteByCondition([
                ['module_id', '=', $id],
                ['controllers', '=', 'App\Http\Controllers\Frontend\ProductController'],
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }

    private function handleSlideItem($request, $languageId)
    {
        $slide = $request->input('slide');
        $temp = [];
        foreach ($slide['image'] as $key => $val) {
            $temp[$languageId][] = [
                'image' => $val,
                'name' => $slide['name'][$key],
                'description' => $slide['description'][$key],
                'canonical' => $slide['canonical'][$key],
                'alt' => $slide['alt'][$key],
                'window' => (isset($slide['window'][$key])) ? $slide['window'][$key] : '',
            ];
        }

        return $temp;
    }


    public function converSlideArray(array $slide = [])
    {
        $temp = [];
        $fields = ['image', 'description', 'window', 'canonical', 'name', 'alt'];
        foreach ($slide as $key => $val) {
            foreach ($fields as $field) {
                $temp[$field][] = $val[$field];
            }
        }

        return $temp;
    }

    private function paginateSelect()
    {
        return [
            'id',
            'name',
            'keyword',
            'item',
            'publish',
        ];
    }

}
