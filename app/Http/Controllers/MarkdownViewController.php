<?php

namespace App\Http\Controllers;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MarkdownViewController extends Controller
{
    public function about(): View
    {
        return $this->showMarkdownPage('about');
    }

    public function examples(): View
    {
        return $this->showMarkdownPage('examples');
    }

    protected function showMarkdownPage(string $view): View
    {
        return view('markdown', [
            'markdown' => new HtmlString(Str::markdown($this->getMarkdownContents($view)))
        ]);
    }

    protected function getMarkdownContents(string $view): string
    {
        return file_get_contents(resource_path("markdown/$view.md"));
    }
}
