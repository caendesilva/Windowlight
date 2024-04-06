<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Hyde\Pages\MarkdownPost;

class HydeController extends Controller
{
    public function posts(): View
    {
        return view('hyde::components.blog-post-feed', [
            'posts' => MarkdownPost::getLatestPosts(),
        ]);
    }
}
