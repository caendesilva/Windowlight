<?php

namespace App\Console\Commands;

use App\Providers\HydeServiceProvider;
use Hyde\Foundation\Facades\Routes;
use Hyde\Framework\Actions\PostBuildTasks\GenerateRssFeed;
use App\Console\Commands\BuildTasks\GenerateSitemap;
use Hyde\Pages\InMemoryPage;
use Hyde\Support\Models\Route as HydeRoute;
use Illuminate\Console\Command;
use Illuminate\Routing\Route;

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
        $routes = [
            'home',
            'about',
            'examples',
            'analytics',
            'analytics.raw',
            'analytics.json',
        ];

        foreach ($routes as $name) {
            $route = app('router')->getRoutes()->getByName($name);
            $hydeRoute = new HydeRoute(new InMemoryPage($route->uri));
            Routes::addRoute($hydeRoute);
        }

        return (new GenerateSitemap())->run($this->output);
    }
}
