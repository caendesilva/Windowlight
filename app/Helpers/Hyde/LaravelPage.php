<?php

namespace App\Helpers\Hyde;

use Hyde\Pages\InMemoryPage;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use ReflectionClass;

class LaravelPage extends InMemoryPage
{
    protected Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;

        parent::__construct($route->uri);
    }

    public function getSourcePath(): string
    {
        $class = Str::before($this->route->getAction('uses'), '@');
        if (class_exists($class)) {
            return (new ReflectionClass($class))->getFileName();
        }
        return '';
    }
}
