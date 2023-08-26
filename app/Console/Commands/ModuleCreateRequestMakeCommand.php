<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class ModuleCreateRequestMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:create:request {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate form request based on the standard DT structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Form Request';

    /**
     * Request type
     *
     * @var string
     */
    protected string $requestType = 'Create';

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws FileNotFoundException
     */
    public function handle(): ?bool
    {
        return parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/entity_create_request.stub';
    }

    /**
     * Get namespace
     *
     * @param string $name
     * @return string
     */
    public function getNamespace($name) :string
    {
        return parent::getNamespace($name) . '\Requests';
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

        return $this->laravel['path'] . '/' . Str::replace('\\', '/', Str::plural($name)) . '/Requests/' . $this->requestType . $this->getClassName($name) . 'Request.php';
    }


}
