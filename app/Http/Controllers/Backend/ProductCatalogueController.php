<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Http\Requests\StoreProductCatalogueRequest;
use App\Http\Requests\UpdateProductCatalogueRequest;
use App\Http\Requests\DeleteProductCatalogueRequest;
use App\Classes\Nestedsetbie;
use Auth;
use App\Models\Language;
use Illuminate\Support\Facades\App;

class ProductCatalogueController extends Controller
{

    protected $productCatalogueService;
    protected $productCatalogueRepository;
    protected $nestedset;
    protected $language;

    public function __construct(
        ProductCatalogueService $productCatalogueService,
        ProductCatalogueRepository $productCatalogueRepository
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });


        $this->productCatalogueService = $productCatalogueService;
        $this->productCatalogueRepository = $productCatalogueRepository;
    }

    private function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'product_catalogues',
            'foreignkey' => 'product_catalogue_id',
            'language_id' => $this->language,
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'product.catalogue.index');
        $productCatalogues = $this->productCatalogueService->paginate($request, $this->language);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/library.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'ProductCatalogue',
        ];
        $config['seo'] = __('messages.productCatalogue');
        return view(
            'backend.product.catalogue.index',
            compact(
                'config',
                'productCatalogues'
            )
        );
    }

    public function create()
    {
        $this->authorize('modules', 'product.catalogue.create');
        $config = $this->configData();
        $config['seo'] = __('messages.productCatalogue');
        $config['method'] = 'create';
        $dropdown = $this->nestedset->Dropdown();
        return view(
            'backend.product.catalogue.create',
            compact(
                'dropdown',
                'config',
            )
        );
    }

    public function store(StoreProductCatalogueRequest $request)
    {
        if ($this->productCatalogueService->create($request, $this->language)) {
            return redirect()->route('product.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('product.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'product.catalogue.edit');
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueById($id, $this->language);
        $config = $this->configData();
        $config['seo'] = __('messages.productCatalogue');
        $config['method'] = 'edit';
        $dropdown = $this->nestedset->Dropdown();
        return view(
            'backend.product.catalogue.create',
            compact(
                'config',
                'dropdown',
                'productCatalogue',
            )
        );
    }

    public function update($id, UpdateProductCatalogueRequest $request)
    {
        if ($this->productCatalogueService->update($id, $request, $this->language)) {
            return redirect()->route('product.catalogue.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('product.catalogue.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'product.catalogue.delete');
        $config['seo'] = __('messages.productCatalogue');
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueById($id, $this->language);
        return view(
            'backend.product.catalogue.delete',
            compact(
                'productCatalogue',
                'config',
            )
        );
    }

    public function destroy(DeleteProductCatalogueRequest $request, $id)
    {
        if ($this->productCatalogueService->destroy($id, $this->language)) {
            return redirect()->route('product.catalogue.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('product.catalogue.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function configData()
    {
        return [
            'js' => [
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]

        ];
    }

}
