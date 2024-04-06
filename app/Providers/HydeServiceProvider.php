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
        // Register the Hyde kernel as a singleton
        $this->app->singleton('hyde', function (): HydeKernel {
            $kernel = new HydeKernel(base_path());
            HydeKernel::setInstance($kernel);

            return $kernel;
        });

        // Define the view hint path for the Hyde package
        $this->loadViewsFrom(base_path('vendor/hyde/framework/resources/views'), 'hyde');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app('hyde')->boot();
    }
}
