<?php

use App\Helpers\Hyde\BlogPostReads;
use App\Models\Analytics\PageViewEvent;

test('can get reads', function () {
    PageViewEvent::factory()->count(5)->create(['page' => 'posts/foo']);
    PageViewEvent::factory()->count(3)->create(['page' => 'posts/bar']);
    PageViewEvent::factory()->count(1)->create(['page' => 'posts/baz']);

    expect(BlogPostReads::all())->toBe([
        'foo' => 5,
        'bar' => 3,
        'baz' => 1,
    ]);
});

test('can get reads for a specific post', function () {
    PageViewEvent::factory()->count(5)->create(['page' => 'posts/foo']);
    PageViewEvent::factory()->count(3)->create(['page' => 'posts/bar']);
    PageViewEvent::factory()->count(1)->create(['page' => 'posts/baz']);

    expect(BlogPostReads::get('foo'))->toBe(5);
    expect(BlogPostReads::get('bar'))->toBe(3);
    expect(BlogPostReads::get('baz'))->toBe(1);
    expect(BlogPostReads::get('unknown'))->toBe(0);
});
