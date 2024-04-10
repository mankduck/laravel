<?php

namespace App\Services;

use App\Services\Interfaces\SystemServiceInterface;
use App\Repositories\Interfaces\SystemRepositoryInterface as SystemRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class SystemService
 * @package App\Services
 */
class SystemService implements SystemServiceInterface
{
    protected $systemRepository;


    public function __construct(
        SystemRepository $systemRepository
    ) {
        $this->systemRepository = $systemRepository;
    }


    public function save($request, $languageId)
    {
        DB::beginTransaction();
        try {

            $config = $request->input('config');
            $payload = [];
            if (count($config)) {
                foreach ($config as $key => $val) {
                    $payload = [
                        'keyword' => $key,
                        'content' => $val,
                        'language_id' => $languageId,
                        'user_id' => Auth::id()
                    ];
                    $condition = ['keyword' => $key, 'language_id' => $languageId];
                    $this->systemRepository->updateOrInsert($payload, $condition);
                }
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



    private function paginateSelect()
    {
        return [
            'id',
            'email',
            'phone',
            'address',
            'name',
            'publish',
            'system_catalogue_id'
        ];
    }


}
