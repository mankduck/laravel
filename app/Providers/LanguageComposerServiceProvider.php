<?php

namespace App\Providers;

use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LanguageComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\Interfaces\LanguageRepositoryInterface', 'App\Repositories\LanguageRepository');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $langugeRepository = $this->app->make(LanguageRepository::class);
            $languages = $langugeRepository->all();
            // dd($language);
            $view->with('languages', $languages);
        });
    }
}
