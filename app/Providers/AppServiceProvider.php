<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GuardianService;
use App\Services\NewsAPIService;
use App\Services\NYTService;
use App\Services\NewsAggregatorService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(NewsAggregatorService::class, function () {
            return new NewsAggregatorService([
                app(NewsAPIService::class),
                app(NYTService::class),
                app(GuardianService::class),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
