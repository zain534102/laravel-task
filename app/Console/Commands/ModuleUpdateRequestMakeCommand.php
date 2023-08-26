<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class ModuleUpdateRequestMakeCommand extends ModuleCreateRequestMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:update:request {name}';

    /**
     * Request type
     *
     * @var string
     */
    protected string $requestType = 'Update';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub():string
    {
        return __DIR__ . '/stubs/entity_update_request.stub';
    }

    public function getPath($name):string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'] . '/' . Str::replace('\\', '/', Str::plural($name)) . '/Requests/' . $this->requestType . $this->getClassName($name) . 'Request.php';
    }
}
