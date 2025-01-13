<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerCatalogueRequest;
use Illuminate\Http\Request;

use App\Services\Interfaces\CustomerCatalogueServiceInterface as CustomerCatalogueService;
use App\Repositories\Interfaces\CustomerCatalogueRepositoryInterface as CustomerCatalogueRepository;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;

class CustomerCatalogueController extends Controller
{
    protected $customerCatalogueService;
    protected $customerCatalogueRepository;
    protected $permissionRepository;

    public function __construct(
        CustomerCatalogueService $customerCatalogueService,
        CustomerCatalogueRepository $customerCatalogueRepository
    ) {
        $this->customerCatalogueService = $customerCatalogueService;
        $this->customerCatalogueRepository = $customerCatalogueRepository;
    }

    public function index(Request $request)
    {
        // $this->authorize('modules', 'customer.catalogue.index');
        $customerCatalogues = $this->customerCatalogueService->paginate($request);
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
            'model' => 'CustomerCatalogue',
        ];
        $config['seo'] = __('messages.customerCatalogue');
        return view(
            'backend.customer.catalogue.index',
            compact(
                'config',
                'customerCatalogues'
            )
        );
    }

    public function create()
    {
        // $this->authorize('modules', 'customer.catalogue.create');
        $config['seo'] = __('messages.customerCatalogue');
        $config['method'] = 'create';
        return view(
            'backend.customer.catalogue.create',
            compact(
                'config',
            )
        );
    }

    public function store(StoreCustomerCatalogueRequest $request)
    {
        if ($this->customerCatalogueService->create($request)) {
            return redirect()->route('customer.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('customer.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'customer.catalogue.edit');
        $customerCatalogue = $this->customerCatalogueRepository->findById($id);
        $config['seo'] = __('messages.customerCatalogue');
        $config['method'] = 'edit';
        return view(
            'backend.customer.catalogue.create',
            compact(
                'config',
                'customerCatalogue',
            )
        );
    }

    public function update($id, StoreCustomerCatalogueRequest $request)
    {
        if ($this->customerCatalogueService->update($id, $request)) {
            return redirect()->route('customer.catalogue.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('customer.catalogue.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        // $this->authorize('modules', 'customer.catalogue.delete');
        $config['seo'] = __('messages.customerCatalogue');
        $customerCatalogue = $this->customerCatalogueRepository->findById($id);
        return view(
            'backend.customer.catalogue.delete',
            compact(
                'customerCatalogue',
                'config',
            )
        );
    }

    public function destroy($id)
    {
        if ($this->customerCatalogueService->destroy($id)) {
            return redirect()->route('customer.catalogue.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('customer.catalogue.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }

}
