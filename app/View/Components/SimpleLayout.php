<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SimpleLayout extends Component
{
    /** @var array<string, string> */
    public array $footer;

    public function __construct(public ?string $title = null)
    {
        $this->footer = [
            'about' => 'About',
            'posts' => 'Blog',
            'terms-of-service' => 'Terms of Service',
            'privacy-policy' => 'Privacy Policy',
        ];
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.simple');
    }
}
