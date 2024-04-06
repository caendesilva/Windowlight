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

    public function post(string $identifier): View
    {
        $post = MarkdownPost::all()->firstWhere('identifier', $identifier);

        if (! $post) {
            abort(404);
        }

        return view('hyde.post', [
            'page' => $post,
            'content' => $post->markdown->toHtml(MarkdownPost::class),
        ]);
    }
}
