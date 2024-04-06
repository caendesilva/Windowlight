<?php

namespace App\Helpers\Hyde;

use App\Models\Analytics\PageViewEvent;
use Illuminate\Support\Collection;

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

        $identifier = "posts/$identifier";

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

        $data = PageViewEvent::all()
            ->groupBy('page')
            ->map(fn (Collection $views): int => $views->count())
            ->toArray();

        static::$reads = $data;
    }
}
