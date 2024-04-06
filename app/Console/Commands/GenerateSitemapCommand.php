<?php

namespace App\Console\Commands;

use App\Providers\HydeServiceProvider;
use App\Console\Commands\BuildTasks\GenerateSitemap;
use App\Helpers\Hyde\LaravelPage;
use Hyde\Foundation\Facades\Routes;
use Hyde\Support\Models\Route;
use Illuminate\Console\Command;

/**
 * @see \Hyde\Console\Commands\BuildRssFeedCommand
 */
class GenerateSitemapCommand extends Command
{
    /** @var string */
    protected $signature = 'build:sitemap';

    /** @var string */
    protected $description = 'Generate the sitemap';

    public function handle(): int
    {
        app()->register(HydeServiceProvider::class);

        // Mix in the Laravel routes into the Hyde routes
        foreach ($this->getRoutes() as $name) {
            $route = app('router')->getRoutes()->getByName($name);
            $hydeRoute = new Route(new LaravelPage($route));
            Routes::addRoute($hydeRoute);
        }

        return (new GenerateSitemap())->run($this->output);
    }

    /** @return string[] */
    protected function getRoutes(): array
    {
        return [
            'home',
            'about',
            'examples',
            'analytics',
            'analytics.raw',
            'analytics.json',
        ];
    }
}
