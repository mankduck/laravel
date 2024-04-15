<?php

namespace App\Services;

use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use Illuminate\Support\Facades\DB;
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

    protected $language;
    protected $routerRepository;
    protected $controllerName = 'PostCatalogueController';


    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        RouterRepository $routerRepository,
    ) {
        $this->language = $this->currentLanguage();
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->language,
        ]);
        $this->routerRepository = $routerRepository;
    }



    public function paginate($request, $languageId)
    {
        $perPage = $request->integer('perpage');
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish'),
            'where' => [
                ['tb2.language_id', '=', $languageId]
            ]
        ];
        $postCatalogues = $this->postCatalogueRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'post.catalogue.index'],
            ['post_catalogues.lft', 'ASC'],
            [
                ['post_catalogue_language as tb2', 'tb2.post_catalogue_id', '=', 'post_catalogues.id']
            ],
            ['languages']
        );
        return $postCatalogues;
    }



    public function create($request, $languageId)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->createCatalogue($request);
            if ($postCatalogue->id > 0) {
                $this->updateLanguageForCatalogue($postCatalogue, $request, $languageId);
                $this->createRouter($postCatalogue, $request, $this->controllerName, $languageId);
                $this->nestedset = new Nestedsetbie([
                    'table' => 'post_catalogues',
                    'foreignkey' => 'post_catalogue_id',
                    'language_id' => $languageId,
                ]);
                $this->nestedset();
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



    public function update($id, $request, $languageId)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->postCatalogueRepository->findById($id);
            $flag = $this->updateCatalogue($postCatalogue, $request);
            if ($flag == TRUE) {
                $this->updateLanguageForCatalogue($postCatalogue, $request, $languageId);
                $this->updateRouter(
                    $postCatalogue,
                    $request,
                    $this->controllerName,
                    $languageId
                );
                $this->nestedset = new Nestedsetbie([
                    'table' => 'post_catalogues',
                    'foreignkey' => 'post_catalogue_id',
                    'language_id' => $languageId,
                ]);
                $this->nestedset();
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



    public function destroy($id, $languageId)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->postCatalogueRepository->delete($id);
            $this->routerRepository->forceDeleteByCondition([
                ['module_id', '=', $id],
                ['controllers', '=', 'App\Http\Controllers\Frontend\PostCatalogueController'],
            ]);

            $this->nestedset = new Nestedsetbie([
                'table' => 'post_catalogues',
                'foreignkey' => 'post_catalogue_id',
                'language_id' => $languageId,
            ]);
            $this->nestedset();

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



    private function createCatalogue($request)
    {
        $payload = $request->only($this->payload());
        $payload['album'] = $this->formatAlbum($request);
        $payload['user_id'] = Auth::id();
        $postCatalogue = $this->postCatalogueRepository->create($payload);
        return $postCatalogue;
    }



    private function updateCatalogue($postCatalogue, $request)
    {
        $payload = $request->only($this->payload());
        $payload['album'] = $this->formatAlbum($request);
        $flag = $this->postCatalogueRepository->update($postCatalogue->id, $payload);
        return $flag;
    }

    private function updateLanguageForCatalogue($postCatalogue, $request, $languageId)
    {
        $payload = $this->formatLanguagePayload($postCatalogue, $request, $languageId);
        $postCatalogue->languages()->detach([$languageId, $postCatalogue->id]);
        $language = $this->postCatalogueRepository->createPivot($postCatalogue, $payload, 'languages');
        return $language;
    }

    private function formatLanguagePayload($postCatalogue, $request, $languageId)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] = $languageId;
        $payload['post_catalogue_id'] = $postCatalogue->id;
        return $payload;
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
            'post_catalogues.id',
            'post_catalogues.publish',
            'post_catalogues.image',
            'post_catalogues.level',
            'post_catalogues.order',
            'tb2.name',
            'tb2.canonical',
        ];
    }

    private function payload()
    {
        return [
            'parent_id',
            'follow',
            'publish',
            'image',
            'album'
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
