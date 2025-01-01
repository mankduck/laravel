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
        $dropdown = $this->nestedset->Dropdown();
        // dd($language);
        return view(
            'backend.promotion.promotion.index',
            compact(
                'config',
                'promotions',
                'dropdown'
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
        $promotion = $this->promotionRepository->getPromotionById($id, $this->language);
        // dd($promotion);
        $config = $this->configData();
        $config['seo'] = __('messages.promotion');
        $config['method'] = 'edit';
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        $album = json_decode($promotion->album);
        // dd($album);
        $catalogue = $this->catalogue($promotion);
        $config['model'] = 'Promotion';
        return view(
            'backend.promotion.promotion.create',
            compact(
                'config',
                'dropdown',
                'promotion',
                'album'
            )
        );
    }

    public function update($id, UpdatePromotionRequest $request)
    {
        if ($this->promotionService->update($id, $request)) {
            return redirect()->route('promotion.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('promotion.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'promotion.delete');
        $config['seo'] = __('messages.promotion');
        $promotion = $this->promotionRepository->getPromotionById($id, $this->language);
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

    private function catalogue($promotion)
    {
        foreach ($promotion as $key => $val) {

        }
    }

    // public function swicthBackendLanguage($id){
    //     $language = $this->languageRepository->findById($id);
    //     if($this->languageService->switch($id)){
    //         session(['app_locale' => $language->canonical]);
    //         \App::setLocale($language->canonical);
    //     }
    //     return redirect()->back();
    // }

    // public function translate($id = 0, $languageId = 0, $model = ''){
    //     $repositoryInstance = $this->respositoryInstance($model);
    //     $languageInstance = $this->respositoryInstance('Language');
    //     $currentLanguage = $languageInstance->findByCondition([
    //         ['canonical' , '=', session('app_locale')]
    //     ]);
    //     $method = 'get'.$model.'ById';

    //     $object = $repositoryInstance->{$method}($id, $currentLanguage->id);
    //     $objectTransate = $repositoryInstance->{$method}($id, $languageId);

    //     $this->authorize('modules', 'language.translate');
    //     $config = [
    //         'js' => [
    //             'backend/plugins/ckeditor/ckeditor.js',
    //             'backend/plugins/ckfinder_2/ckfinder.js',
    //             'backend/library/finder.js',
    //             'backend/library/seo.js',
    //             'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
    //         ],
    //         'css' => [
    //             'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
    //         ]
    //     ];
    //     $option = [
    //         'id' => $id,
    //         'languageId' => $languageId,
    //         'model' => $model,
    //     ];
    //     $config['seo'] = config('apps.language');
    //     $template = 'backend.language.translate';
    //     return view('backend.dashboard.layout', compact(
    //         'template',
    //         'config',
    //         'object',
    //         'objectTransate',
    //         'option',
    //     ));
    // }

    // public function storeTranslate(TranslateRequest $request){
    //     $option = $request->input('option');
    //     if($this->languageService->saveTranslate($option, $request)){
    //         return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
    //     }
    //     return redirect()->back()->with('error','Có vấn đề xảy ra, Hãy Thử lại');
    // }

    // private function respositoryInstance($model){
    //     $repositoryNamespace = '\App\Repositories\\' . ucfirst($model) . 'Repository';
    //     if (class_exists($repositoryNamespace)) {
    //         $repositoryInstance = app($repositoryNamespace);
    //     }
    //     return $repositoryInstance ?? null;
    // }

}
