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
            return new HydeKernel(base_path());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
