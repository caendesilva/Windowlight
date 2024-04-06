<?php

namespace App\Helpers;

use Hyde\Foundation\Facades\Routes;
use Hyde\Framework\Features\XmlGenerators\SitemapGenerator as HydeSitemapGenerator;
use Hyde\Support\Models\Route;

class SitemapGenerator extends HydeSitemapGenerator
{
    public function generate(): static
    {
        $routes = Routes::all();

        $routes->each(function (Route $route): void {
            $this->addRoute($route);
        });

        return $this;
    }
}
