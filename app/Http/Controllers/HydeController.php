<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use Hyde\Pages\MarkdownPost;

class HydeController extends Controller
{
    public function posts(): View
    {
        return view('markdown', [
            'title' => 'Latest Posts',
            'markdown' => new HtmlString(view('hyde::components.blog-post-feed', [
                'posts' => MarkdownPost::getLatestPosts(),
            ]))
        ]);
    }
}
