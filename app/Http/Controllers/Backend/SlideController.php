<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\SlideServiceInterface as SlideService;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Classes\Nestedsetbie;
use App\Models\Language;

class SlideController extends Controller
{
    protected $slideService;
    protected $slideRepository;
    protected $languageRepository;
    protected $language;

    public function __construct(
        SlideService $slideService,
        SlideRepository $slideRepository,
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });

        $this->slideService = $slideService;
        $this->slideRepository = $slideRepository;
        $this->initialize();

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
        $config = $this->configData();
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
            'model' => 'Slide'
        ];
        $slides = $this->slideService->paginate($request);

        // dd($users);
        $config['seo'] = __('messages.slide');
        return view(
            'backend.slide.slide.index',
            compact(
                'config',
                'slides'
            )
        );
    }

    public function create()
    {
        // $this->authorize('modules', 'product.create');

        $config = $this->configData();
        $config['seo'] = __('messages.slide');
        $config['method'] = 'create';
        $dropdown = $this->nestedset->Dropdown();
        return view(
            'backend.slide.slide.create',
            compact(
                'dropdown',
                'config',
            )
        );
    }

    public function store(StoreSlideRequest $request)
    {
        echo 123; die;
        if ($this->slideService->create($request, $this->language)) {
            return redirect()->route('slide.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('slide.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'product.update');
        $slide = $this->slideRepository->getProductById($id, $this->language);
        $config = $this->configData();
        $config['seo'] = __('messages.slide');
        $config['method'] = 'edit';
        $dropdown = $this->nestedset->Dropdown();
        return view(
            'backend.slide.slide.create',
            compact(
                'config',
                'dropdown',
                'slide',
            )
        );
    }

    public function update($id, UpdateSlideRequest $request)
    {
        if ($this->slideService->update($id, $request, $this->language)) {
            return redirect()->route('slide.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('slide.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        // $this->authorize('modules', 'product.destroy');
        $config['seo'] = __('messages.slide');
        $slide = $this->slideRepository->getProductById($id, $this->language);
        return view(
            'backend.slide.slide.delete',
            compact(
                'slide',
                'config',
            )
        );
    }

    public function destroy($id)
    {
        if ($this->slideService->destroy($id, $this->language)) {
            return redirect()->route('slide.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('slide.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function configData()
    {
        return [
            'js' => [
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'backend/library/slide.js',
                'backend/library/variant.js',
                'backend/library/library.js',
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/nice-select/js/jquery.nice-select.min.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                'backend/plugins/nice-select/css/nice-select.css',
                'backend/css/plugins/switchery/switchery.css',
            ]

        ];
    }



}
