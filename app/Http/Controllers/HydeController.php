<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Hyde\Pages\MarkdownPost;
use Hyde\Pages\InMemoryPage;

class HydeController extends Controller
{
    public function posts(): View
    {
        return view('hyde.posts', [
            'page' => new InMemoryPage('posts'),
            'posts' => MarkdownPost::getLatestPosts(),
        ]);
    }
}
