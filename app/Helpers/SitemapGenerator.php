<?php

namespace App\Helpers;

use Hyde\Foundation\Facades\Routes;
use Hyde\Framework\Features\XmlGenerators\SitemapGenerator as HydeSitemapGenerator;
use Hyde\Pages\MarkdownPost;
use Hyde\Support\Models\Route;

class SitemapGenerator extends HydeSitemapGenerator
{
    public function generate(): static
    {
        $routes = Routes::all();

        // Sort routes to put blog posts last
        $routes = $routes->sortBy(fn (Route $route): int => $route->getPage() instanceof MarkdownPost ? 1 : 0);

        $routes->each(function (Route $route): void {
            $this->addRoute($route);
        });

        return $this;
    }
}
