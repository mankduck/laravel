<?php

namespace App\Services;

use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
// use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Classes\Nestedsetbie;

/**
 * Class LanguageService
 * @package App\Services
 */
class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;
    protected $nestedset;

    protected $language;
    protected $routerRepository;


    public function __construct(
        PostRepository $postRepository,
        // RouterRepository $routerRepository,
    ) {
        $this->language = $this->currentLanguage();
        $this->postRepository = $postRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->language,
        ]);
        // $this->routerRepository = $routerRepository;
    }



    public function paginate($request)
    {

        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $condition['where'] = [
            ['tb2.language_id', '=', $this->language]
        ];



        $perPage = $request->integer('perpage');
        $posts = $this->postRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'post.index', 'groupBy' => $this->paginateSelect()],
            [
                'posts.id',
                'DESC'
            ],

            [
                ['post_language as tb2', 'tb2.post_id', '=', 'posts.id'],
                ['post_catalogue_post as tb3', 'posts.id', '=', 'tb3.post_id']
            ],
            ['post_catalogues'],
            $this->whereRaw($request)
        );
        // dd($posts);

        return $posts;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $post = $this->createForPost($request);
            if ($post->id > 0) {
                $this->updateLanguageForPost($post, $request);
                $this->updateCatalogueForPost($post, $request);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }


    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->findById($id);
            if ($this->uploadPost($post, $request)) {
                $this->updateLanguageForPost($post, $request);
                $this->updateCatalogueForPost($post, $request);
            }


            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->delete($id); //Soft Delete
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }


    private function createForPost($request)
    {
        $payload = $request->only($this->payload());
        $payload['album'] = $this->formatAlbum($request);
        $payload['user_id'] = Auth::id();
        $post = $this->postRepository->create($payload);
        return $post;
    }


    private function uploadPost($post, $request)
    {
        $payload = $request->only($this->payload());
        $payload['album'] = $this->formatAlbum($request);
        return $this->postRepository->update($post->id, $payload);
    }

    private function formatAlbum($request)
    {
        return ($request->input('album') && !empty($request->input('album'))) ? json_encode($request->input('album')) : '';
    }


    private function updateLanguageForPost($post, $request)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload = $this->formatLanguagePayload($payload, $post->id);
        $post->languages()->detach([$this->language, $post->id]);
        return $this->postRepository->createPivot($post, $payload, 'languages');
    }

    private function formatLanguagePayload($payload, $postId)
    {
        $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] = $this->language;
        $payload['post_id'] = $postId;
        return $payload;
    }


    private function updateCatalogueForPost($post, $request)
    {
        $post->post_catalogues()->sync($this->catalogue($request));
    }

    private function catalogue($request)
    {
        // dd($request);
        if ($request->input('catalogue') != null) {
            return array_unique(array_merge($request->input('catalogue'), [$request->post_catalogue_id]));
        }
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1) ? 2 : 1);
            $language = $this->postRepository->update($post['modelId'], $payload);
            // $this->changeUserStatus($post, $payload[$post['field']]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];
            $flag = $this->postRepository->updateByWhereIn('id', $post['id'], $payload);
            // $this->changeUserStatus($post, $post['value']);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }


    private function whereRaw($request)
    {
        $rawCondition = [];
        if ($request->integer('post_catalogue_id') > 0) {
            $rawCondition['whereRaw'] = [
                [
                    'tb3.post_catalogue_id IN (
                        SELECT id FROM post_catalogues WHERE lft >= (SELECT lft FROM post_catalogues as pc WHERE pc.id = ?) AND rgt <= (SELECT rgt FROM post_catalogues as pc WHERE pc.id = ?)
                    )',
                    [$request->integer('post_catalogue_id'), $request->integer('post_catalogue_id')],
                ]
            ];
        }
        return $rawCondition;
    }

    // public function switch($id){
    //     DB::beginTransaction();
    //     try{
    //         $language = $this->languageRepository->update($id, ['current' => 1]);
    //         $payload = ['current' => 0];
    //         $where = [
    //             ['id', '!=', $id],
    //         ];
    //         $this->languageRepository->updateByWhere($where, $payload);

    //         DB::commit();
    //         return true;
    //     }catch(\Exception $e ){
    //         DB::rollBack();
    //         // Log::error($e->getMessage());
    //         echo $e->getMessage();die();
    //         return false;
    //     }

    // }

    // public function saveTranslate($option, $request){
    //     DB::beginTransaction();
    //     try{
    //         $payload = [
    //             'name' => $request->input('translate_name'),
    //             'description' => $request->input('translate_description'),
    //             'content' => $request->input('translate_content'),
    //             'meta_title' => $request->input('translate_meta_title'),
    //             'meta_keyword' => $request->input('translate_meta_keyword'),
    //             'meta_description' => $request->input('translate_meta_description'),
    //             'canonical' => $request->input('translate_canonical'),
    //             $this->converModelToField($option['model']) => $option['id'],
    //             'language_id' => $option['languageId']
    //         ];
    //         $controllerName = $option['model'].'Controller';
    //         $repositoryNamespace = '\App\Repositories\\' . ucfirst($option['model']) . 'Repository';
    //         if (class_exists($repositoryNamespace)) {
    //             $repositoryInstance = app($repositoryNamespace);
    //         }
    //         $model = $repositoryInstance->findById($option['id']);
    //         $model->languages()->detach([$option['languageId'], $model->id]);
    //         $repositoryInstance->createPivot($model, $payload,'languages');

    //         $this->routerRepository->forceDeleteByCondition(
    //             [
    //                 ['module_id', '=', $option['id']],
    //                 ['controllers', '=', 'App\Http\Controllers\Frontend\\'.$controllerName],
    //                 ['language_id', '=', $option['languageId']]
    //             ]
    //         );
    //         $router = [
    //             'canonical' => Str::slug($request->input('translate_canonical')),
    //             'module_id' => $model->id,
    //             'language_id' => $option['languageId'],
    //             'controllers' => 'App\Http\Controllers\Frontend\\'.$controllerName.'',
    //         ];
    //         $this->routerRepository->create($router);
    //         DB::commit();
    //         return true;
    //     }catch(\Exception $e ){
    //         DB::rollBack();
    //         // Log::error($e->getMessage());
    //         echo $e->getMessage();die();
    //         return false;
    //     }
    // }

    // private function converModelToField($model){
    //     $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $model));
    //     return $temp.'_id';
    // }


    private function paginateSelect()
    {
        return [
            'posts.id',
            'posts.publish',
            'posts.image',
            'posts.order',
            'tb2.name',
            'tb2.canonical',
        ];
    }

    private function payload()
    {
        return [
            'post_catalogue_id',
            'follow',
            'publish',
            'image',
            'album',
        ];
    }

    private function payloadLanguage()
    {
        return [
            'name',
            'description',
            'content',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'canonical'
        ];
    }


}
