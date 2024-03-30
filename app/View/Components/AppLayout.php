<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function __construct(public ?string $title = null)
    {
        //
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app', [
            'canonical' => $this->canonical(),
        ]);
    }

    /**
     * Get a dynamic canonical URL for the current page, always using the official domain.
     */
    protected function canonical(): string
    {
        $path = request()->path();

        return 'https://windowlight.desilva.se/' . ($path === '/' ? '' : $path);
    }
}
