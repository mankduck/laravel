<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Models\System;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use Illuminate\Http\Request;

class ProductCatalogueController extends FrontendController
{
    protected $productCatalogueRepository;
    protected $productService;

    public function __construct(
        ProductCatalogueRepository $productCatalogueRepository,
        ProductService $productService
    ) {
        parent::__construct();
        $this->productCatalogueRepository = $productCatalogueRepository;
        $this->productService = $productService;
    }
    public function index($id, $request)
    {
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueById($id, $this->language);
        $breadcrumb = $this->productCatalogueRepository->breadcrumb($productCatalogue, $this->language);
        $products = $this->productService->paginate($request, $this->language, $productCatalogue, ['path' => $productCatalogue->canonical]);

        $productId = $products->pluck('id')->toArray();
        if(count($productId) && !is_null($productId)){
            $products = $this->productService->comebineProductAndPromotion($productId, $products);
        }
        $system = $this->system;
        $seo = seo($productCatalogue);

        return view('frontend.homepage.product.catalogue_index', compact('productCatalogue', 'system', 'seo', 'breadcrumb', 'products'));
    }
}
