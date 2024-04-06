<?php

namespace App\Providers;

use Hyde\Foundation\HydeKernel;
use Illuminate\Support\ServiceProvider;

class HydeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('hyde', function (): HydeKernel {
            $kernel = new HydeKernel(base_path());
            HydeKernel::setInstance($kernel);

            return $kernel;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app('hyde')->boot();
    }
}
