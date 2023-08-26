<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class ModuleFeatureTestMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:feature:test {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate feature test based on the standard DT structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Feature Test';

    /**
     * Execute the console command.
     * @return mixed
     * @throws FileNotFoundException
     */
    public function handle():mixed
    {
        return parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub():string
    {
        return __DIR__ . '/stubs/entity_feature_test.stub';
    }

    /**
     * Root namespace
     *
     * @return string
     */
    protected function rootNamespace():string
    {
        return 'Tests';
    }

    /**
     * Get default namespace
     *
     * @param string $rootNamespace
     * @return string
     */
    public function getDefaultNamespace($rootNamespace):string
    {
        return $rootNamespace . '\Feature';
    }

    /**
     * Get path
     *
     * @param string $name
     * @return string
     */
    public function getPath($name):string
    {
        $path = Str::plural(
            Str::replaceFirst($this->rootNamespace(), '', $name)
        );

        return base_path('tests') .
            Str::replace('\\', '/', $path) . '/' . $this->getClassName($name) .
            'FeatureTest.php';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name):BaseGeneratorCommand
    {
        $stub = Str::replace(
            [
                'DummyTestNamespace',
                'DummyRootNamespace',
                //'DummyPluralClass',
                'DummyModuleNamespace',
                //'dummyResourceKey',
                'dummyTableName',
                //'dummyRepository',
                'dummyModel',
                //'dummyPluralModel',
                'dummySnakeModel',
                //'dummyPluralSnakeModel',
                'DUMMY_TABLE_NAME',
                'dummyPluralDashModel'
            ],
            [
                $this->getNamespace($name),
                $this->rootNamespace(),
                //str_plural($this->getClassName($name)),
                Str::replaceFirst($this->rootNamespace() . '\Feature', 'App\Modules', parent::getNamespace($name)),
                //$this->getTableName(),
                $this->getTableName(),
                //Str::snake($this->getClassName($name)) . 'Repository',
                Str::camel($this->getClassName($name)),
                //str_plural(Str::camel($this->getClassName($name))),
                Str::snake($this->getClassName($name)),
                //str_plural(Str::snake($this->getClassName($name))),
                strtoupper(Str::plural(Str::snake($this->getClassName($name))) . '_table'),
                str_replace('_', '-', $this->getTableName())
            ],
            $stub
        );

        return $this;
    }
}
