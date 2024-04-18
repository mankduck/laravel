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
            $product = $this->createProduct($request);
            if ($product->id > 0) {
                $this->updateLanguageForProduct($product, $request, $languageId);
                $this->updateCatalogueForProduct($product, $request);
                $this->createRouter($product, $request, $this->controllerName, $languageId);

                $this->createVariant($product, $request, $languageId);
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

    public function update($id, $request, $languageId)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->findById($id);
            if ($this->uploadProduct($product, $request)) {
                $this->updateLanguageForProduct($product, $request, $languageId);
                $this->updateCatalogueForProduct($product, $request);
                $this->updateRouter(
                    $product,
                    $request,
                    $this->controllerName,
                    $languageId
                );

                $product->product_variants()->each(function ($variant) {
                    $variant->languages()->detach();
                    $variant->attributes()->detach();
                    $variant->delete();
                });
                $this->createVariant($product, $request, $languageId);
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


    private function createVariant($product, $request, $languageId)
    {
        $payload = $request->only(['variant', 'productVariant', 'attribute']);
        $variant = $this->createVariantArray($payload);
        // dd($variant);
        $variants = $product->product_variants()->createMany($variant);
        $variantId = $variants->pluck('id');
        $productVariantLanguage = [];
        $variantAttribute = [];
        $attributeCombines = $this->comebineAttribute(array_values($payload['attribute']));

        if (count($variantId)) {
            foreach ($variantId as $key => $val) {
                $productVariantLanguage[] = [
                    'product_variant_id' => $val,
                    'language_id' => $languageId,
                    'name' => $payload['productVariant']['name'][$key]
                ];


                if (count($attributeCombines)) {
                    foreach ($attributeCombines[$key] as $attributeId) {
                        $variantAttribute[] = [
                            'product_variant_id' => $val,
                            'attribute_id' => $attributeId
                        ];
                    }
                }
                // if (count($payload['attribute'])) {
                //     foreach ($payload['attribute'] as $keyAttr => $valAttr) {
                //         if (count($valAttr)) {
                //             foreach ($valAttr as $attr) {
                //                 $variantAttribute[] = [
                //                     'product_variant_id' => $val,
                //                     'attribute_id' => $attr
                //                 ];
                //             }
                //         }
                //     }
                // }
            }
        }

        // dd($variantAttribute);


        // dd($variantAttribute);
        $variantLanguage = $this->productVariantLanguageRepository->createBatch($productVariantLanguage);
        $variantAttribute = $this->productVariantAttributeRepository->createBatch($variantAttribute);

        // CREATE VARIANT ATTRIBUTE


    }


    private function comebineAttribute($attributes = [], $index = 0)
    {
        if ($index === count($attributes))
            return [[]];

        $subCombines = $this->comebineAttribute($attributes, $index + 1);

        $combine = [];
        foreach ($attributes[$index] as $key => $val) {
            foreach ($subCombines as $keySub => $valSub) {
                $combine[] = array_merge([$val], $valSub);
            }
        }
        return $combine;
    }

    private function createVariantArray(array $payload = [])
    {
        $variant = [];
        $translate = [];
        if (isset($payload['variant']['sku']) && count($payload['variant']['sku'])) {
            foreach ($payload['variant']['sku'] as $key => $value) {
                $variant[] = [
                    'code' => ($payload['productVariant']['id'][$key]) ?? '',
                    'quantity' => ($payload['variant']['quantity'][$key]) ?? '',
                    'sku' => $value,
                    'price' => ($payload['variant']['price'][$key]) ? convert_price($payload['variant']['price'][$key]) : '',
                    'barcode' => ($payload['variant']['barcode'][$key]) ?? '',
                    'file_name' => ($payload['variant']['file_name'][$key]) ?? '',
                    'file_url' => ($payload['variant']['file_url'][$key]) ?? '',
                    'album' => ($payload['variant']['album'][$key]) ?? '',
                    'user_id' => Auth::id(),
                ];
            }
        }
        return $variant;
    }

    private function createProduct($request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::id();
        $payload['album'] = $this->formatAlbum($request);
        $payload['price'] = convert_price($payload['price']);
        $payload['attributeCatalogue'] = $this->formatJson($request, 'attributeCatalogue');
        $payload['attribute'] = $this->formatJson($request, 'attribute');
        $payload['variant'] = $this->formatJson($request, 'variant');
        $product = $this->productRepository->create($payload);
        return $product;
    }

    private function uploadProduct($product, $request)
    {
        $payload = $request->only($this->payload());
        $payload['album'] = $this->formatAlbum($request);
        $payload['price'] = convert_price($payload['price']);
        return $this->productRepository->update($product->id, $payload);
    }


    private function updateLanguageForProduct($product, $request, $languageId)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload = $this->formatLanguagePayload($payload, $product->id, $languageId);
        $product->languages()->detach([$languageId, $product->id]);
        return $this->productRepository->createPivot($product, $payload, 'languages');
    }

    private function updateCatalogueForProduct($product, $request)
    {
        $product->product_catalogues()->sync($this->catalogue($request));
    }

    private function formatLanguagePayload($payload, $productId, $languageId)
    {
        $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] = $languageId;
        $payload['product_id'] = $productId;
        return $payload;
    }


    private function catalogue($request)
    {
        if ($request->input('catalogue') != null) {
            return array_unique(array_merge($request->input('catalogue'), [$request->product_catalogue_id]));
        }
        return [$request->product_catalogue_id];
    }


    private function whereRaw($request, $languageId)
    {
        $rawCondition = [];
        if ($request->integer('product_catalogue_id') > 0) {
            $rawCondition['whereRaw'] = [
                [
                    'tb3.product_catalogue_id IN (
                        SELECT id
                        FROM product_catalogues
                        JOIN product_catalogue_language ON product_catalogues.id = product_catalogue_language.product_catalogue_id
                        WHERE lft >= (SELECT lft FROM product_catalogues as pc WHERE pc.id = ?)
                        AND rgt <= (SELECT rgt FROM product_catalogues as pc WHERE pc.id = ?)
                        AND product_catalogue_language.language_id = ' . $languageId . '
                    )',
                    [$request->integer('product_catalogue_id'), $request->integer('product_catalogue_id')]
                ]
            ];

        }
        return $rawCondition;
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
