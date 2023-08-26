<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ModuleRequestsMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:requests {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate create and update requests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $this->call('make:module:create:request', [
            'name' => $name
        ]);
        $this->call('make:module:update:request', [
            'name' => $name
        ]);
    }
}
