<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class ModuleTransformerMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:transformer {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate transformer based on the standard IF structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Transformer';

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
        return __DIR__ . '/stubs/entity_transformer.stub';
    }

    /**
     * Get namespace
     *
     * @param string $name
     * @return string
     */
    public function getNamespace($name) :string
    {
        return parent::getNamespace($name) . '\Transformers';
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
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyModel', 'dummyModel'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->getNamespacedModel($name), Str::camel($this->getClassName($name))],
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

        return $this->laravel['path'] . '/' . str_replace('\\', '/', Str::plural($name)) . '/Transformers/' . $this->getClassName($name) . 'Transformer.php';
    }

}
