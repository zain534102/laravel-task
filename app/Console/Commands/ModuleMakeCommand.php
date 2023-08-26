<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ModuleMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name} {--controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the necessary files for the IF module structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createMigration();
        $this->createModel();
        $this->createTransformer();
        $this->createRepository();
        $this->createFactory();
        $this->createUnitTest();

        if ($this->option('controller')) {
            $this->createRequests();
            $this->createController();
            $this->createFeatureTest();
            $this->createService();
        }
    }

    /**
     * Create migration
     */
    private function createMigration():void
    {
        $this->call('make:migration', [
            'name' => 'create_' . Str::snake(str_replace('/', '', Str::plural($this->argument('name')))) . '_table'
        ]);
    }

    /**
     * Create model
     */
    private function createModel():void
    {
        $this->call('make:module:model', [
            'name' => $this->argument('name')
        ]);
    }

    /**
     * Create transformer
     */
    private function createTransformer():void
    {
        $this->call('make:module:transformer', [
            'name' => $this->argument('name')
        ]);
    }

    /**
     * Create repository
     */
    private function createRepository():void
    {
        $this->call('make:module:repository:contract', [
            'name' => $this->argument('name')
        ]);
        $this->call('make:module:repository', [
            'name' => $this->argument('name')
        ]);
    }

    /**
     * Create factory
     */
    private function createFactory():void
    {
        $this->call('make:module:factory', [
            'name' => $this->argument('name')
        ]);
    }

    /**
     * Create unit test
     */
    private function createUnitTest():void
    {
        $this->call('make:module:unit:test', [
            'name' => $this->argument('name')
        ]);
    }

    /**
     * Create requests
     */
    private function createRequests():void
    {
        $this->call('make:module:create:request', [
            'name' => $this->argument('name')
        ]);
        $this->call('make:module:update:request', [
            'name' => $this->argument('name')
        ]);
    }

    /**
     * Create controller
     */
    private function createController():void
    {
        $this->call('make:module:controller', [
            'name' => $this->argument('name')
        ]);
    }

    /**
     * Create feature test
     */
    private function createFeatureTest():void
    {
        $this->call('make:module:feature:test', [
            'name' => $this->argument('name')
        ]);
    }
    /**
     * Create service
     */
    private function createService():void
    {
        $this->call('make:module:service', [
            'name' => $this->argument('name')
        ]);
    }

}
