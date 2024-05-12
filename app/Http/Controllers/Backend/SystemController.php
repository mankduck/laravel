<?php

namespace App\Http\Controllers\Backend;

use App\Classes\System;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Repositories\Interfaces\SystemRepositoryInterface as SystemRepository;
use App\Services\Interfaces\SystemServiceInterface as SystemService;
use Illuminate\Http\Request;


class SystemController extends Controller
{
    protected $systemLibrary;
    protected $systemService;
    protected $systemRepository;

    public function __construct(System $systemLibrary, SystemService $systemService, SystemRepository $systemRepository)
    {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });

        $this->systemLibrary = $systemLibrary;
        $this->systemService = $systemService;
        $this->systemRepository = $systemRepository;
    }


    public function index()
    {
        $this->authorize('modules', 'system.index');
        $systemConfig = $this->systemLibrary->config();
        $systems = convert_array($this->systemRepository->findByCondition([['language_id', '=', $this->language]], TRUE), 'keyword', 'content');
        $config = $this->config();
        $config['seo'] = __('messages.system');
        return view('backend.system.index', compact('config', 'systemConfig', 'systems'));
    }


    public function store(Request $request)
    {
        if ($this->systemService->save($request, $this->language)) {
            return redirect()->route('system.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('system.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }



    public function translate($languageId = 0)
    {
        $this->authorize('modules', 'system.translate');
        $systemConfig = $this->systemLibrary->config();
        $systems = convert_array($this->systemRepository->findByCondition([['language_id', '=', $languageId]], TRUE), 'keyword', 'content');
        $config = $this->config();
        $config['seo'] = __('messages.system');
        $config['method'] = 'translate';
        return view('backend.system.index', compact('config', 'systemConfig', 'systems', 'languageId'));
    }


    public function saveTranslate(Request $request, $languageId)
    {
        if ($this->systemService->save($request, $languageId)) {
            return redirect()->route('system.translate', ['languageId' => $languageId])->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('system.translate', ['languageId' => $languageId])->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }


    private function config()
    {
        return [

            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/library.js',
                'backend/plugins/ckeditor/ckeditor.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
        ];
    }
}
