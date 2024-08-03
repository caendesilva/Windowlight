<?php

namespace App\Helpers;

use Illuminate\Support\Number;
use Illuminate\Support\Str;

/**
 * General helper functions for the Windowlight code snippet generator app.
 */
class WindowlightHelper
{
    /** @experimental */
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

    public static function hslToHex(int $h, int $s, int $l): string
    {
        $h /= 360;
        $s /= 100;
        $l /= 100;

        $r = $g = $b = $l;

        $v = ($l <= 0.5) ? ($l * (1.0 + $s)) : ($l + $s - $l * $s);
        if ($v > 0) {
            $m = $l + $l - $v;
            $sv = ($v - $m) / $v;
            $h *= 6.0;
            $sextant = floor($h);
            $fract = $h - $sextant;
            $vsf = $v * $sv * $fract;
            $mid1 = $m + $vsf;
            $mid2 = $v - $vsf;

            switch ($sextant) {
                case 0:
                    $r = $v;
                    $g = $mid1;
                    $b = $m;
                    break;
                case 1:
                    $r = $mid2;
                    $g = $v;
                    $b = $m;
                    break;
                case 2:
                    $r = $m;
                    $g = $v;
                    $b = $mid1;
                    break;
                case 3:
                    $r = $m;
                    $g = $mid2;
                    $b = $v;
                    break;
                case 4:
                    $r = $mid1;
                    $g = $m;
                    $b = $v;
                    break;
                case 5:
                    $r = $v;
                    $g = $m;
                    $b = $mid2;
                    break;
            }
        }

        $r = round($r * 255);
        $g = round($g * 255);
        $b = round($b * 255);

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}
