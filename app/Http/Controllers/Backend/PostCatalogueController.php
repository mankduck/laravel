<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostCatalogueRequest;
use App\Models\Language;
use Illuminate\Http\Request;

use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Http\Requests\StorePostCatalogueRequest;
use App\Http\Requests\UpdatePostCatalogueRequest;
use App\Http\Requests\TranslateRequest;

class PostCatalogueController extends Controller
{
    protected $postCatalogueService;
    protected $postCatalogueRepository;
    protected $nestedset;
    protected $language;

    public function __construct(
        PostCatalogueService $postCatalogueService,
        PostCatalogueRepository $postCatalogueRepository
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });


        $this->postCatalogueService = $postCatalogueService;
        $this->postCatalogueRepository = $postCatalogueRepository;
    }

    private function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->language,
        ]);
    }



    public function index(Request $request)
    {
        $this->authorize('modules', 'post.catalogue.index');
        $postCatalogues = $this->postCatalogueService->paginate($request, $this->language);

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
            'model' => 'PostCatalogue',
        ];
        $config['seo'] = __('messages.postCatalogue');
        return view(
            'backend.post.catalogue.index',
            compact(
                'config',
                'postCatalogues'
            )
        );
    }

    public function create()
    {
        $this->authorize('modules', 'post.catalogue.create');
        $config = $this->configData();
        $config['seo'] = __('messages.postCatalogue');
        $config['method'] = 'create';
        $dropdown = $this->nestedset->Dropdown();
        $config['model'] = 'PostCatalogue';
        return view(
            'backend.post.catalogue.create',
            compact(
                'config',
                'dropdown'
            )
        );
    }

    public function store(StorePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->create($request, $this->language)) {
            return redirect()->route('post.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('post.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'post.catalogue.edit');
        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($id, $this->language);
        // dd($postCatalogue);
        $config = $this->configData();
        $config['seo'] = __('messages.postCatalogue');
        $config['method'] = 'edit';
        $dropdown = $this->nestedset->Dropdown();
        $album = json_decode($postCatalogue->album);
        // dd($album);
        $config['model'] = 'PostCatalogue';
        return view(
            'backend.post.catalogue.create',
            compact(
                'config',
                'dropdown',
                'postCatalogue',
                'album'
            )
        );
    }

    public function update($id, UpdatePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->update($id, $request, $this->language)) {
            return redirect()->route('post.catalogue.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('post.catalogue.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'post.catalogue.delete');
        $config['seo'] = __('messages.postCatalogue');
        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($id, $this->language);
        return view(
            'backend.post.catalogue.delete',
            compact(
                'postCatalogue',
                'config',
            )
        );
    }

    public function destroy($id, DeletePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->destroy($id, $this->language)) {
            return redirect()->route('post.catalogue.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('post.catalogue.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function configData()
    {
        return [
            'js' => [
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'backend/library/library.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]

        ];
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
