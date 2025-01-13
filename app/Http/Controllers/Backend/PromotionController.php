<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

use App\Services\Interfaces\PromotionServiceInterface as PromotionService;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Repositories\Interfaces\SourceRepositoryInterface as SourceRepository;
use App\Http\Requests\Promotion\StorePromotionRequest;
use App\Http\Requests\Promotion\UpdatePromotionRequest;
use App\Http\Requests\TranslateRequest;

class PromotionController extends Controller
{
    protected $promotionService;
    protected $promotionRepository;
    protected $sourceRepository;
    protected $language;

    public function __construct(
        PromotionService $promotionService,
        PromotionRepository $promotionRepository,
        SourceRepository $sourceRepository
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            // $this->initialize();
            return $next($request);
        });

        $this->promotionService = $promotionService;
        $this->promotionRepository = $promotionRepository;
        $this->sourceRepository = $sourceRepository;
        // $this->initialize();

    }

    // private function initialize()
    // {
    //     $this->nestedset = new Nestedsetbie([
    //         'table' => 'promotion_catalogues',
    //         'foreignkey' => 'promotion_catalogue_id',
    //         'language_id' => $this->language,
    //     ]);
    // }



    public function index(Request $request)
    {
        $this->authorize('modules', 'promotion.index');
        $promotions = $this->promotionService->paginate($request, $this->language);
        // dd($promotions);

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
            'model' => 'Promotion',
        ];
        $config['seo'] = __('messages.promotion');
        // dd($language);
        return view(
            'backend.promotion.promotion.index',
            compact(
                'config',
                'promotions',
            )
        );
    }

    public function create()
    {
        $this->authorize('modules', 'promotion.create');
        $sources = $this->sourceRepository->all();
        $config = $this->configData();
        $config['seo'] = __('messages.promotion');
        $config['method'] = 'create';
        // $dropdown = $this->nestedset->Dropdown();
        $config['model'] = 'Promotion';
        return view(
            'backend.promotion.promotion.create',
            compact(
                'config',
                'sources'
            )
        );
    }

    public function store(StorePromotionRequest $request)
    {
        if ($this->promotionService->create($request, $this->language)) {
            return redirect()->route('promotion.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('promotion.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'promotion.edit');
        $promotion = $this->promotionRepository->findById($id);
        // dd($promotion->discountInformation);
        $sources = $this->sourceRepository->all();
        $config = $this->configData();
        $config['seo'] = __('messages.promotion');
        $config['method'] = 'edit';
        $config['model'] = 'Promotion';
        return view(
            'backend.promotion.promotion.create',
            compact(
                'config',
                'promotion',
                'sources'
            )
        );
    }

    public function update($id, UpdatePromotionRequest $request)
    {
        if ($this->promotionService->update($id, $request, $this->language)) {
            return redirect()->route('promotion.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('promotion.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'promotion.delete');
        $config['seo'] = __('messages.promotion');
        $promotion = $this->promotionRepository->findById($id);
        return view(
            'backend.promotion.promotion.delete',
            compact(
                'promotion',
                'config',
            )
        );
    }

    public function destroy($id)
    {
        if ($this->promotionService->destroy($id)) {
            return redirect()->route('promotion.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('promotion.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function configData()
    {
        return [
            'js' => [
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/promotion.js',
                'backend/library/seo.js',
                'backend/library/library.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]

        ];
    }



}
