<?php

namespace App\Services;

use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
// use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
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
class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    protected $nestedset;
    protected $routerRepository;


    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        // RouterRepository $routerRepository,
    ) {
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->currentLanguage(),
        ]);
        // $this->routerRepository = $routerRepository;
    }



    public function paginate($request)
    {

        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $postCatalogues = $this->postCatalogueRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'PostCatalogue/index'],
        );
        return $postCatalogues;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $payload['user_id'] = Auth::id();
            $postCatalogue = $this->postCatalogueRepository->create($payload);
            // echo $postCatalogues->id;die;
            if ($postCatalogue->id > 0) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_catalogue_id'] = $postCatalogue->id;

                $language = $this->postCatalogueRepository->createLanguagePivot($postCatalogue, $payloadLanguage);
                // dd($language);
            }

            $this->nestedset->Get('level ASC, order ASC');
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


    // public function update($id, $request)
    // {
    //     DB::beginTransaction();
    //     try {

    //         $payload = $request->except(['_token', 'send']);
    //         $language = $this->languageRepository->update($id, $payload);
    //         DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         // Log::error($e->getMessage());
    //         echo $e->getMessage();
    //         die();
    //         return false;
    //     }
    // }

    // public function destroy($id)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $language = $this->languageRepository->delete($id);

    //         DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         // Log::error($e->getMessage());
    //         echo $e->getMessage();
    //         die();
    //         return false;
    //     }
    // }

    // public function updateStatus($post = [])
    // {
    //     DB::beginTransaction();
    //     try {
    //         $payload[$post['field']] = (($post['value'] == 1) ? 2 : 1);
    //         $language = $this->languageRepository->update($post['modelId'], $payload);
    //         // $this->changeUserStatus($post, $payload[$post['field']]);

    //         DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         // Log::error($e->getMessage());
    //         echo $e->getMessage();
    //         die();
    //         return false;
    //     }
    // }

    // public function updateStatusAll($post)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $payload[$post['field']] = $post['value'];
    //         $flag = $this->languageRepository->updateByWhereIn('id', $post['id'], $payload);
    //         // $this->changeUserStatus($post, $post['value']);

    //         DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         // Log::error($e->getMessage());
    //         echo $e->getMessage();
    //         die();
    //         return false;
    //     }
    // }

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
            'id',
            'name',
            'canonical',
            'publish',
            'image'
        ];
    }

    private function payload()
    {
        return ['parent_id', 'follow', 'publish', 'image'];
    }

    private function payloadLanguage()
    {
        return ['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical'];
    }


}
