<?php

namespace App\Helpers\Hyde;

use Hyde\Pages\InMemoryPage;
use Illuminate\Routing\Route;

class LaravelPage extends InMemoryPage
{
    protected Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;

        parent::__construct($route->uri);
    }
}
