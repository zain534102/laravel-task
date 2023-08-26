<?php

namespace App\Providers;

class RepositoryServiceProvider extends BaseRepositoryServiceProvider
{
    /**
     * Module name which need to be injected in IOC
     *
     * @var array|string[]
     */
    protected array $modules = [
        'UserSubmission'
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        parent::register();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
