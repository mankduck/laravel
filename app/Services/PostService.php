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
            ['path' => 'post.index'],
            [
                'posts.id',
                'DESC'
            ],

            [
                ['post_language as tb2', 'tb2.post_id', '=', 'posts.id']
            ]
        );
        // dd($posts);

        return $posts;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $payload['user_id'] = Auth::id();
            $payload['album'] = json_encode($payload['album']);
            // dd($payload);

            $post = $this->postRepository->create($payload);
            // echo $posts->id;die;
            if ($post->id > 0) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                // dd($payloadLanguage);
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $payloadLanguage['language_id'] = $this->language;
                $payloadLanguage['post_id'] = $post->id;

                $language = $this->postRepository->createPivot($post, $payloadLanguage, 'languages');
                // dd($language);


                $catalogue = $this->catalogue($request);
                // dd($catalogue);
                $post->post_catalogues()->sync($catalogue);

            }

            // $this->nestedset->Get('level ASC, order ASC');
            // $this->nestedset->Recursive(0, $this->nestedset->Set());
            // $this->nestedset->Action();

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
            $payload = $request->only($this->payload());
            $payload['album'] = json_encode($payload['album']);
            $flag = $this->postRepository->update($id, $payload);
            if ($flag == TRUE) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $this->language;
                $payloadLanguage['post_catalogue_id'] = $id;
                $post->languages()->detach([$payloadLanguage['language_id'], $id]);
                // dd($payloadLanguage); 
                $response = $this->postRepository->createLanguagePivot($post, $payloadLanguage);
                $this->nestedset->Get('level ASC', 'order ASC');
                $this->nestedset->Recursive(0, $this->nestedset->Set());
                $this->nestedset->Action();

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
            $post = $this->postRepository->delete($id);

            $this->nestedset->Get('level ASC', 'order ASC');
            $this->nestedset->Recursive(0, $this->nestedset->Set());
            $this->nestedset->Action();

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

    private function catalogue($request)
    {
        // dd($request);
        return array_unique(array_merge($request->input('catalogue'), [$request->post_catalogue_id]));
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
            'posts.level',
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
