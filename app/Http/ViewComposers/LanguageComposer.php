<?php

namespace App\Http\ViewComposers;

use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use Illuminate\View\View;

class LanguageComposer
{
    protected $languageRepository;
    public function __construct(
        LanguageRepository $languageRepository,
    ) {
        $this->languageRepository = $languageRepository;
    }
    public function compose(View $view)
    {
        $agrument = $this->agrument();
        $languages = $this->languageRepository->findByCondition(...$agrument);
        // dd($languages);
        $view->with('language', $languages);
    }


    private function agrument()
    {
        return [
            'condition' => [
                config('apps.general.defaultPublish')
            ],
            'flag' => true,
            'relation' => [],
            'orderBy' => ['current', 'DESC']
        ];
    }
}