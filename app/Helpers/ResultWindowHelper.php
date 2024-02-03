<?php

namespace App\Helpers;

use Illuminate\Support\Number;
use Illuminate\Support\Str;

class ResultWindowHelper
{
    public static function calculateWindowWidth(string $html): int
    {
        // Extract the highlighted code
        $html = Str::between($html, '<!-- Syntax highlighted by torchlight.dev -->', '</code></pre>');

        // Split the HTML into lines
        $lines = explode("<div class='line'>", $html);

        // Find the longest line
        $length = max(array_map(fn (string $line): int => strlen(strip_tags($line)), $lines));

        // Clamp the length to a reasonable value
        return Number::clamp($length + 4, 10, 120);
    }
}
