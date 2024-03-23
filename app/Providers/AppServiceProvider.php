<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        'App\Services\Interfaces\UserServiceInterface' => 'App\Services\UserService',
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
        Schema::defaultStringLength(191);
    }
}
