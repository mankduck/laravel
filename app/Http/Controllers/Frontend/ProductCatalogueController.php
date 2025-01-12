<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Models\System;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use Illuminate\Http\Request;

class ProductCatalogueController extends FrontendController
{
    protected $productCatalogueRepository;



    public function __construct(
        ProductCatalogueRepository $productCatalogueRepository,
    ) {
        parent::__construct();
        $this->productCatalogueRepository = $productCatalogueRepository;
    }
    public function index($id, $language)
    {
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueById($id, $language);

        $system = convert_array(System::where('language_id', $language)->get(), 'keyword', 'content');
        $seo = [
            'meta_title' => ($productCatalogue->meta_title) ?? $productCatalogue->name,
            'meta_keyword' => ($productCatalogue->meta_keyword) ??'',
            'meta_description' => ($productCatalogue->meta_description) ?? $productCatalogue->description,
            'canonical' => $productCatalogue->canonical,
        ];

        return view('frontend.homepage.product.catalogue_index', compact('productCatalogue', 'system', 'seo'));
    }
}
