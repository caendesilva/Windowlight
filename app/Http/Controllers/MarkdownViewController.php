<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class MarkdownViewController extends Controller
{
    public function about()
    {
        return view('about', [
            'markdown' => new HtmlString(Str::markdown(file_get_contents(resource_path('markdown/about.md'))))
        ]);
    }
}
