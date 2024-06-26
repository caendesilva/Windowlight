<?php

namespace App\Helpers\Hyde;

use App\Models\Analytics\PageViewEvent;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BlogPostReads
{
    /** @var array<string, int> */
    protected static $reads = [];

    public static function all(): array
    {
        static::loadIfEmpty();

        return static::$reads;
    }

    public static function get(string $identifier): int
    {
        static::loadIfEmpty();

        return static::$reads[$identifier] ?? 0;
    }

    protected static function loadIfEmpty(): void
    {
        if (empty(static::$reads)) {
            static::load();
        }
    }

    protected static function load(): void
    {
        // We use the analytics feature to get the reads

        // With over 5000 records, this takes about 30ms to run. With 500 records, it takes about 5ms.
        // So for now we don't need to worry about caching it to disk. But we can do that later if needed.

        $data = PageViewEvent::all()
            ->groupBy('page')
            ->map(fn (Collection $views): int => $views->count())
            ->reject(function (int $count, string $page): bool {
                return ! str_contains($page, 'posts/');
            })
            ->mapWithKeys(function (int $count, string $page): array {
                $page = Str::after($page, 'posts/');

                return [$page => $count];
            })
            ->toArray();

        static::$reads = $data;
    }
}
