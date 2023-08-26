<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use App\Console\Commands\BaseGeneratorCommand;
class ModuleControllerMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:controller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate controller based on the standard IF structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Execute the console command.
     * @return bool|null
     * @throws FileNotFoundException
     */
    public function handle():?bool
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
        return __DIR__ . '/stubs/entity_controller.stub';
    }

    /**
     * Get default namespace
     *
     * @param string $rootNamespace
     * @return string
     */
    public function getDefaultNamespace($rootNamespace) :string
    {
        return $rootNamespace . '\Http\Controllers\API\V1';
    }

    /**
     * Get path
     *
     * @param string $name
     * @return string
     */
    public function getPath($name) :string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'] . '/' . Str::replace('\\', '/', Str::singular($name)) . 'Controller.php';
    }

    /**
     * Get namespace
     *
     * @param string $name
     * @return string
     */
    public function getNamespace($name) :string
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name) :self
    {
        $stub = Str::replace(
            [
                'DummyNamespace',
                'DummyRootNamespace',
                'dummyModel',
                'DummyModuleNamespace',
                'DummyPluralClass',
                'dummyRepository',
                'dummyPluralModel',
                'dummyService'
            ],
            [
                $this->getNamespace($name),
                $this->rootNamespace(),
                Str::camel($this->getClassName($name)),
                Str::replaceFirst('Http\Controllers\API\V1', 'Modules', parent::getNamespace($name)),
                Str::singular($this->getClassName($name)),
                Str::camel($this->getClassName($name) . 'Repository'),
                Str::camel(Str::plural($this->getClassName($name))),
                Str::camel($this->getClassName($name) . 'Service'),
            ],
            $stub
        );

        return $this;
    }
}
