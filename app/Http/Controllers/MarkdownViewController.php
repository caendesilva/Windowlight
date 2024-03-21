<?php

namespace App\Http\Controllers;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MarkdownViewController extends Controller
{
    public function about(): View
    {
        return view('markdown', [
            'markdown' => new HtmlString(Str::markdown(file_get_contents(resource_path('markdown/about.md'))))
        ]);
    }
}
