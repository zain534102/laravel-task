<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

abstract class BaseGeneratorCommand extends GeneratorCommand
{
    /**
     * Get class name
     * @param $name
     * @return string|null
     */
    protected function getClassName($name):?string
    {
        $names = explode('\\', $name);
        return array_pop($names);
    }

    /**
     * Replace class
     * @param string $stub
     * @param string $name
     * @return string|array
     */
    protected function replaceClass($stub, $name):string|array
    {
        $class = $this->getClassName($name);
        return str_replace('DummyClass', $class, $stub);
    }

    /**
     * Get default namespace
     *
     * @param string $rootNamespace
     * @return string
     */
    public function getDefaultNamespace($rootNamespace):string
    {
        return $rootNamespace . '\Modules';
    }

    /**
     * Get namespace
     *
     * @param string $name
     * @return string
     */
    public function getNamespace($name):string
    {
        return parent::getNamespace($name) . '\\' . Str::plural($this->getClassName($name));
    }

    /**
     * Get path
     *
     * @param string $name
     * @return string
     */
    public function getPath($name):string
    {
        return Str::plural($name) . '\\' . $this->getClassName($name) . '.php';
    }

    /**
     * Get namespaced model
     *
     * @param $name
     * @return string
     */
    public function getNamespacedModel($name):string
    {
        return self::getNamespace($name) . '\\' . $this->getClassName($name);
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName():string
    {
        return Str::plural(
            str_replace('/', '', Str::snake($this->getNameInput()))
        );
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name):self
    {
        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyModel', 'dummyModel', 'dummyTableName'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->getNamespacedModel($name), Str::camel($this->getClassName($name)), $this->getTableName()],
            $stub
        );

        return $this;
    }

    /**
     * Get the command input value
     *
     * @return string
     */
    protected function getNameInput():string
    {
        return trim($this->argument('name'));
    }

}

