<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\WidgetServiceInterface as WidgetService;
use App\Repositories\Interfaces\WidgetRepositoryInterface as WidgetRepository;

use App\Http\Requests\StoreWidgetRequest;
use App\Http\Requests\UpdateWidgetRequest;

class WidgetController extends Controller
{
    protected $widgetService;
    protected $widgetRepository;

    public function __construct(
        WidgetService $widgetService,
        WidgetRepository $widgetRepository,
    ) {
        $this->widgetService = $widgetService;
        $this->widgetRepository = $widgetRepository;
    }
    public function index(Request $request)
    {
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
            'model' => 'Widget'
        ];

        $widgets = $this->widgetService->paginate($request);
        // dd($widgets);
        $config['seo'] = __('messages.widget');

        return view('backend.widget.index', compact('config', 'widgets'));
    }

    public function create()
    {
        $this->authorize('modules', 'widget.create');
        $config = $this->config();
        $config['seo'] = __('messages.widget');
        $config['method'] = 'create';
        return view(
            'backend.widget.create',
            compact(
                'config',
            )
        );
    }

    public function store(StoreWidgetRequest $request)
    {
        if ($this->widgetService->create($request)) {
            return redirect()->route('widget.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('widget.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'widget.edit');
        $widget = $this->widgetRepository->findById($id);
        $provinces = $this->provinceRepository->all();
        $config = $this->config();
        $config['seo'] = __('messages.widget');
        $config['method'] = 'edit';
        return view(
            'backend.widget.create',
            compact(
                'config',
                'provinces',
                'widget',
            )
        );
    }

    public function update($id, UpdateWidgetRequest $request)
    {
        if ($this->widgetService->update($id, $request)) {
            return redirect()->route('widget.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('widget.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'widget.delete');
        $config['seo'] = __('messages.widget');
        $widget = $this->widgetRepository->findById($id);
        return view(
            'backend.widget.delete',
            compact(
                'widget',
                'config',
            )
        );
    }

    public function destroy($id)
    {
        if ($this->widgetService->destroy($id)) {
            return redirect()->route('widget.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('widget.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }



    private function config()
    {
        return [

            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/location.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/plugins/ckeditor/ckeditor.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
        ];
    }
}
