<?php

namespace App\Helpers\Hyde;

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

        return static::$reads[$identifier];
    }

    protected static function loadIfEmpty(): void
    {
        if (empty(static::$reads)) {
            static::load();
        }
    }
}
