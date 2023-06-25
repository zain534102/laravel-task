<?php

namespace App\Providers;

use App\Modules\Job\Contract\JobService as JobServiceContract;
use App\Modules\Job\Services\JobService;
use Illuminate\Support\ServiceProvider;

class ServiceLayerProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(JobServiceContract::class,JobService::class);
    }
}
