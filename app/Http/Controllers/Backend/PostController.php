<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\TranslateRequest;

class PostController extends Controller
{
    protected $postService;
    protected $postRepository;
    protected $language;

    public function __construct(
        PostService $postService,
        PostRepository $postRepository,
    ) {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1,
        ]);
        $this->language = $this->currentLanguage();
    }

    public function index(Request $request)
    {
        // $this->authorize('modules', 'language.index');
        $posts = $this->postService->paginate($request);
        // dd($posts);

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
            'model' => 'Post',
        ];
        $config['seo'] = __('messages.post');
        $dropdown = $this->nestedset->Dropdown();
        // dd($language);
        return view(
            'backend.post.post.index',
            compact(
                'config',
                'posts',
                'dropdown'
            )
        );
    }

    public function create()
    {
        // $this->authorize('modules', 'language.create');
        $config = $this->configData();
        $config['seo'] = __('messages.post');
        $config['method'] = 'create';
        $dropdown = $this->nestedset->Dropdown();
        $config['model'] = 'Post';
        return view(
            'backend.post.post.create',
            compact(
                'config',
                'dropdown'
            )
        );
    }

    public function store(StorePostRequest $request)
    {
        if ($this->postService->create($request)) {
            return redirect()->route('post.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('post.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'language.update');
        $post = $this->postRepository->getPostById($id, $this->language);
        // dd($post);
        $config = $this->configData();
        $config['seo'] = __('messages.post');
        $config['method'] = 'edit';
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        $album = json_decode($post->album);
        // dd($album);
        $catalogue = $this->catalogue($post);
        $config['model'] = 'Post';
        return view(
            'backend.post.post.create',
            compact(
                'config',
                'dropdown',
                'post',
                'album'
            )
        );
    }

    public function update($id, UpdatePostRequest $request)
    {
        if ($this->postService->update($id, $request)) {
            return redirect()->route('post.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('post.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        // $this->authorize('modules', 'language.delete');
        $config['seo'] = __('messages.post');
        $post = $this->postRepository->getPostById($id, $this->language);
        return view(
            'backend.post.post.delete',
            compact(
                'post',
                'config',
            )
        );
    }

    public function destroy($id)
    {
        if ($this->postService->destroy($id)) {
            return redirect()->route('post.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('post.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
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

    private function catalogue($post)
    {
        foreach ($post as $key => $val) {

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
