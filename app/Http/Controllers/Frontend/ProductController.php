<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Models\System;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use Illuminate\Http\Request;

class ProductController extends FrontendController
{
    protected $productCatalogueRepository;
    protected $productService;
    protected $productRepository;

    public function __construct(
        ProductCatalogueRepository $productCatalogueRepository,
        ProductService $productService,
        ProductRepository $productRepository
    ) {
        parent::__construct();
        $this->productCatalogueRepository = $productCatalogueRepository;
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }
    public function index($id, $request)
    {
        $product = $this->productRepository->getProductById($id, $this->language);
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueById($product->product_catalogue_id, $this->language);
        $breadcrumb = $this->productCatalogueRepository->breadcrumb($productCatalogue, $this->language);
        if(isset($product->attribute) && count($product->attribute)){
            $product = $this->productService->getAttribute($product, $this->language);
        }
        $variant = $product->product_variants->toArray();
        $system = $this->system;
        $seo = seo($product);

        return view('frontend.homepage.product.product_index', compact('product', 'system', 'seo', 'breadcrumb', 'variant'));
    }
}
