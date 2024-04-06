<?php

namespace App\Providers;

use Hyde\Foundation\HydeKernel;
use Illuminate\Foundation\AliasLoader;
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
            return tap(new HydeKernel(base_path()), function (HydeKernel $kernel): void {
                HydeKernel::setInstance($kernel);
            });
        });

        // Register facade aliases to use in the views
        foreach ($this->getAliases() as $alias => $class) {
            AliasLoader::getInstance()->alias($alias, $class);
        }

        // Define the view hint path for the Hyde package
        $this->loadViewsFrom(base_path('vendor/hyde/framework/resources/views'), 'hyde');

        // Merge Hyde configuration settings
        foreach ($this->getHydeConfig() as $config => $data) {
            $this->app->make('config')->set($config, $data);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app('hyde')->boot();
    }

    /** @return string[] */
    protected function getAliases(): array
    {
        return [
            'Hyde' => \Hyde\Hyde::class,
            'Site' => \Hyde\Facades\Site::class,
            'Asset' => \Hyde\Facades\Asset::class,
            'Features' => \Hyde\Facades\Features::class,
            'Routes' => \Hyde\Foundation\Facades\Routes::class,
            'Includes' => \Hyde\Support\Includes::class,
            'MarkdownPost' => \Hyde\Pages\MarkdownPost::class,
        ];
    }

    /** @return array<string, array<string, mixed>> */
    protected function getHydeConfig(): array
    {
        return [
            'hyde' => [
                'pretty_urls' => true,
            ],
        ];
    }
}
