<?php

declare(strict_types=1);

namespace Webparking\LaravelClio\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelClioServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerConfig();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/clio.php',
            'clio'
        );

        $this->publishes([
            __DIR__ . '/../../config/clio.php' => config_path('clio.php'),
        ], 'config');
    }
}
