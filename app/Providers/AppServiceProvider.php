<?php

namespace App\Providers;

use App\Http\ViewComposers\LanguageComposer;
use App\Http\ViewComposers\MenuComposer;
use App\Http\ViewComposers\SystemComposer;
use App\Models\Language;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        'App\Services\Interfaces\UserServiceInterface' => 'App\Services\UserService',
        'App\Repositories\Interfaces\UserRepositoryInterface' => 'App\Repositories\UserRepository',

        'App\Services\Interfaces\UserCatalogueServiceInterface' => 'App\Services\UserCatalogueService',
        'App\Repositories\Interfaces\UserCatalogueRepositoryInterface' => 'App\Repositories\UserCatalogueRepository',

        'App\Repositories\Interfaces\ProvinceRepositoryInterface' => 'App\Repositories\ProvinceRepository',
        'App\Repositories\Interfaces\DistrictRepositoryInterface' => 'App\Repositories\DistrictRepository',

        'App\Services\Interfaces\LanguageServiceInterface' => 'App\Services\LanguageService',
        'App\Repositories\Interfaces\LanguageRepositoryInterface' => 'App\Repositories\LanguageRepository',

        'App\Services\Interfaces\PostCatalogueServiceInterface' => 'App\Services\PostCatalogueService',
        'App\Repositories\Interfaces\PostCatalogueRepositoryInterface' => 'App\Repositories\PostCatalogueRepository',

        'App\Services\Interfaces\PostServiceInterface' => 'App\Services\PostService',
        'App\Repositories\Interfaces\PostRepositoryInterface' => 'App\Repositories\PostRepository',

        'App\Repositories\Interfaces\RouterRepositoryInterface' => 'App\Repositories\RouterRepository',

        'App\Services\Interfaces\PermissionServiceInterface' => 'App\Services\PermissionService',
        'App\Repositories\Interfaces\PermissionRepositoryInterface' => 'App\Repositories\PermissionRepository',

        'App\Services\Interfaces\GenerateServiceInterface' => 'App\Services\GenerateService',
        'App\Repositories\Interfaces\GenerateRepositoryInterface' => 'App\Repositories\GenerateRepository',

        'App\Services\Interfaces\ProductServiceInterface' => 'App\Services\ProductService',
        'App\Repositories\Interfaces\ProductRepositoryInterface' => 'App\Repositories\ProductRepository',

        'App\Services\Interfaces\ProductCatalogueServiceInterface' => 'App\Services\ProductCatalogueService',
        'App\Repositories\Interfaces\ProductCatalogueRepositoryInterface' => 'App\Repositories\ProductCatalogueRepository',

        'App\Services\Interfaces\AttributeServiceInterface' => 'App\Services\AttributeService',
        'App\Repositories\Interfaces\AttributeRepositoryInterface' => 'App\Repositories\AttributeRepository',

        'App\Services\Interfaces\AttributeCatalogueServiceInterface' => 'App\Services\AttributeCatalogueService',
        'App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface' => 'App\Repositories\AttributeCatalogueRepository',

        'App\Repositories\Interfaces\ProductVariantRepositoryInterface' => 'App\Repositories\ProductVariantRepository',

        'App\Repositories\Interfaces\ProductVariantLanguageRepositoryInterface' => 'App\Repositories\ProductVariantLanguageRepository',

        'App\Repositories\Interfaces\ProductVariantAttributeRepositoryInterface' => 'App\Repositories\ProductVariantAttributeRepository',

        'App\Services\Interfaces\SystemServiceInterface' => 'App\Services\SystemService',
        'App\Repositories\Interfaces\SystemRepositoryInterface' => 'App\Repositories\SystemRepository',

        'App\Services\Interfaces\MenuServiceInterface' => 'App\Services\MenuService',
        'App\Repositories\Interfaces\MenuRepositoryInterface' => 'App\Repositories\MenuRepository',

        'App\Services\Interfaces\MenuCatalogueServiceInterface' => 'App\Services\MenuCatalogueService',
        'App\Repositories\Interfaces\MenuCatalogueRepositoryInterface' => 'App\Repositories\MenuCatalogueRepository',

        'App\Services\Interfaces\SlideServiceInterface' => 'App\Services\SlideService',
        'App\Repositories\Interfaces\SlideRepositoryInterface' => 'App\Repositories\SlideRepository',

        'App\Services\Interfaces\WidgetServiceInterface' => 'App\Services\WidgetService',
        'App\Repositories\Interfaces\WidgetRepositoryInterface' => 'App\Repositories\WidgetRepository',
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->bindings as $key => $val) {
            $this->app->bind($key, $val);
        }

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $locale = app()->getLocale();
        $language = Language::where('canonical', $locale)->first();


        view()->composer('frontend.layout', function ($view) use ($language) {
            $composerClasses = [
                SystemComposer::class,
                MenuComposer::class,
                LanguageComposer::class
            ];

            foreach ($composerClasses as $key => $val) {
                $composer = app()->make($val, ['language' => $language->id]);
                $composer->compose($view);
            }
        });

        Schema::defaultStringLength(191);
    }
}
