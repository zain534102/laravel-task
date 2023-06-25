<?php

namespace Tests;

use App\Providers\ServiceLayerProvider;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->register(ServiceLayerProvider::class);
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
