<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Services\Interfaces\WidgetServiceInterface as WidgetService;
use App\Repositories\Interfaces\WidgetRepositoryInterface as WidgetRepository;

use App\Http\Requests\StoreWidgetRequest;
use App\Http\Requests\UpdateWidgetRequest;
use Illuminate\Support\Collection;

class WidgetController extends Controller
{
    protected $widgetService;
    protected $widgetRepository;
    protected $language;
    protected $languageRepository;

    public function __construct(
        WidgetService $widgetService,
        WidgetRepository $widgetRepository,
        LanguageRepository $languageRepository
    ) {
        $this->widgetService = $widgetService;
        $this->widgetRepository = $widgetRepository;
        $this->languageRepository = $languageRepository;
        ;
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });
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
        if ($this->widgetService->create($request, $this->language)) {
            return redirect()->route('widget.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('widget.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    private function menuItemAgrument(array $whereIn = [])
    {
        $language = $this->language;
        return [
            'condition' => [],
            'flag' => true,
            'relation' => [
                'languages' => function ($query) use ($language) {
                    $query->where('language_id', $language);
                }
            ],
            'orderBy' => ['id', 'desc'],
            'param' => [
                'whereIn' => $whereIn,
                'whereInField' => 'id'
            ]
        ];
    }

    public function edit($id)
    {
        $this->authorize('modules', 'widget.edit');
        $widget = $this->widgetRepository->findById($id);
        $widget->description = $widget->description[$this->language];
        $modelClass = loadClass($widget->model);
        $widgetItem = convertArrayByKey($modelClass->findByCondition(
            ...array_values($this->menuItemAgrument($widget->model_id))
        ), ['id', 'name.languages', 'image']);
        $config = $this->config();
        $config['model'] = 'Widget';
        $config['seo'] = __('messages.widget');
        $config['method'] = 'edit';
        return view(
            'backend.widget.create',
            compact(
                'config',
                'widget',
                'widgetItem'
            )
        );
    }

    public function update($id, UpdateWidgetRequest $request)
    {
        if ($this->widgetService->update($id, $request, $this->language)) {
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

    public function translate($languageId, $widgetId)
    {
        $this->authorize('modules', 'widget.translate');

        $widget = $this->widgetRepository->findById($widgetId);

        $widget->jsonDescription = $widget->description;
        $widget->description = $widget->description[$this->language];

        $widgetTranslate = new \stdClass;
        $widgetTranslate->description = ($widget->jsonDescription[$languageId]) ?? '';

        // $widgetTranslate->description = $widgetTranslate->description[$languageId];
        // dd($widgetTranslate->description);

        $translate = $this->languageRepository->findById($languageId);
        $config = $this->config();
        $config['seo'] = __('messages.widget');
        $config['method'] = 'translate';
        return view(
            'backend.widget.translate',
            compact(
                'config',
                'widget',
                'translate',
                'widgetTranslate'
            )
        );
    }

    public function saveTranslate(Request $request)
    {
        if ($this->widgetService->saveTranslate($request, $this->language)) {
            return redirect()->route('widget.index')->with('success', 'Tạo bản dịch thành công');
        }
        return redirect()->route('widget.index')->with('error', 'Tạo bản dịch không thành công. Hãy thử lại');
    }

    private function config()
    {
        return [

            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/widget.js',
                'backend/plugins/ckeditor/ckeditor.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
        ];
    }
}
