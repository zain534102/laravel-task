<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class ModuleRepositoryContractMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:repository:contract {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate repository contract based on the standard IF structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Repository Contract';

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
        return __DIR__ . '/stubs/entity_repository_contract.stub';
    }

    /**
     * Get namespace
     *
     * @param string $name
     * @return string
     */
    public function getNamespace($name) :string
    {
        return parent::getNamespace($name) . '\Contracts\Repositories';
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
        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyModel', 'DummyPluralClass'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->getNamespacedModel($name), Str::plural($this->getClassName($name))],
            $stub
        );

        return $this;
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
        $name = Str::plural($name);
        $className = Str::singular($this->getClassName($name));
        return $this->laravel['path'] . '/' . Str::replace('\\', '/', $name) . '/Contracts/Repositories/' . $className . 'Repository.php';
    }

}
