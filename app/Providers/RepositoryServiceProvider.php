<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends BaseRepositoryServiceProvider
{
    /**
     * Module name which need to be injected in IOC
     *
     * @var array|string[]
     */
    protected array $modules = [];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
