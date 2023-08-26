<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
abstract class BaseRepositoryServiceProvider extends ServiceProvider
{
    protected array $modules = [];
    protected string $moduleDirectory = 'App\Modules';
    protected string $contractDirectory = 'Contracts\Repositories';
    protected string $repositoryDirectory = 'Repositories';

    /**
     * Get model name from module
     *
     * @param string $module
     * @return string
     */
    private function getModelName(string $module): string
    {
        $chunks = explode('\\', $module);
        return array_pop($chunks);
    }

    /**
     * Get repository class name
     *
     * @param string $module
     * @return string
     */
    private function getRepositoryClassName(string $module): string
    {
        return $this->getModelName($module) . 'Repository';
    }

    /**
     * Get repository contract class by module name
     *
     * @param string $module
     * @return string
     */
    private function getRepositoryContractClassByModule(string $module): string
    {
        return $this->moduleDirectory . '\\' . Str::plural($module) . '\\' . $this->contractDirectory . '\\' . $this->getRepositoryClassName($module);
    }

    /**
     * Get repository class by module name
     *
     * @param string $module
     * @return string
     */
    private function getRepositoryClassByModule(string $module): string
    {
        return $this->moduleDirectory . '\\' . Str::plural($module) . '\\' . $this->repositoryDirectory . '\\' . $this->getRepositoryClassName($module);
    }

    /**
     * Register the repositories
     */
    public function register(): void
    {
        foreach ($this->modules as $module) {
            $this->app->bind(
                $this->getRepositoryContractClassByModule($module),
                $this->getRepositoryClassByModule($module)
            );
        }
    }


}
