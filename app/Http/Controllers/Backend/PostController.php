<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\DeletePostRequest;
use App\Classes\Nestedsetbie;
use App\Models\Language;

class PostController extends Controller
{
    protected $postService;
    protected $postRepository;
    // protected $languageRepository;
    protected $language;

    public function __construct(
        PostService $postService,
        PostRepository $postRepository,
    ) {
        // $this->middleware(function ($request, $next) {
        //     $locale = app()->getLocale(); // vn en cn
        //     $language = Language::where('canonical', $locale)->first();
        //     $this->language = $language->id;
        //     $this->initialize();
        //     return $next($request);
        // });

        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1,
        ]);
        $this->language = $this->currentLanguage();
        // $this->initialize();

    }


    public function index(Request $request)
    {
        // $this->authorize('modules', 'language.index');
        $posts = $this->postService->paginate($request);

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
        $config['seo'] = config('apps.post');
        return view(
            'backend.post.post.index',
            compact(
                'config',
                'posts'
            )
        );
    }

    public function create()
    {
        // $this->authorize('modules', 'language.create');
        $config = $this->configData();
        $config['seo'] = config('apps.post');
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
        $post = $this->postRepository->getPostCatalogueById($id, $this->language);
        // dd($postCatalogue);
        $config = $this->configData();
        $config['seo'] = config('apps.post');
        $config['method'] = 'edit';
        $dropdown = $this->nestedset->Dropdown();
        $album = json_decode($post->album);
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
        $config['seo'] = config('apps.postc');
        $post = $this->postRepository->getPostCatalogueById($id, $this->language);
        return view(
            'backend.post.post.delete',
            compact(
                'post',
                'config',
            )
        );
    }

    public function destroy($id, DeletePostRequest $request)
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

    // private function initialize()
    // {
    //     $this->nestedset = new Nestedsetbie([
    //         'table' => 'post_catalogues',
    //         'foreignkey' => 'post_catalogue_id',
    //         'language_id' => $this->language,
    //     ]);
    // }

    // public function index(Request $request)
    // {
    //     // $this->authorize('modules', 'post.index');
    //     $posts = $this->postService->paginate($request, $this->language);
    //     $config = [
    //         'js' => [
    //             'backend/js/plugins/switchery/switchery.js',
    //             'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
    //         ],
    //         'css' => [
    //             'backend/css/plugins/switchery/switchery.css',
    //             'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
    //         ],
    //         'model' => 'Post'
    //     ];
    //     $config['seo'] = __('messages.post');
    //     $dropdown = $this->nestedset->Dropdown();
    //     return view(
    //         'backend.post.post.index',
    //         compact(
    //             'config',
    //             'dropdown',
    //             'posts'
    //         )
    //     );
    // }

    // public function create()
    // {
    //     // $this->authorize('modules', 'post.create');
    //     $config = $this->configData();
    //     $config['seo'] = __('messages.post');
    //     $config['method'] = 'create';
    //     $dropdown = $this->nestedset->Dropdown();
    //     return view(
    //         'backend.post.post.create',
    //         compact(
    //             'dropdown',
    //             'config',
    //         )
    //     );
    // }

    // public function store(StorePostRequest $request)
    // {
    //     if ($this->postService->create($request, $this->language)) {
    //         return redirect()->route('post.index')->with('success', 'Thêm mới bản ghi thành công');
    //     }
    //     return redirect()->route('post.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    // }

    // public function edit($id)
    // {
    //     // $this->authorize('modules', 'post.update');
    //     $post = $this->postRepository->getPostById($id, $this->language);
    //     $config = $this->configData();
    //     $config['seo'] = __('messages.post');
    //     $config['method'] = 'edit';
    //     $dropdown = $this->nestedset->Dropdown();
    //     $album = json_decode($post->album);
    //     return view(
    //         'backend.post.post.create',
    //         compact(
    //             'config',
    //             'dropdown',
    //             'post',
    //             'album',
    //         )
    //     );
    // }

    // public function update($id, UpdatePostRequest $request)
    // {
    //     if ($this->postService->update($id, $request)) {
    //         return redirect()->route('post.index')->with('success', 'Cập nhật bản ghi thành công');
    //     }
    //     return redirect()->route('post.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    // }

    // public function delete($id)
    // {
    //     // $this->authorize('modules', 'post.destroy');
    //     $config['seo'] = __('messages.post');
    //     $post = $this->postRepository->getPostById($id, $this->language);
    //     return view(
    //         'backend.post.post.delete',
    //         compact(
    //             'post',
    //             'config',
    //         )
    //     );
    // }

    // public function destroy($id)
    // {
    //     if ($this->postService->destroy($id)) {
    //         return redirect()->route('post.index')->with('success', 'Xóa bản ghi thành công');
    //     }
    //     return redirect()->route('post.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    // }

    // private function configData()
    // {
    //     return [
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
    // }



}
