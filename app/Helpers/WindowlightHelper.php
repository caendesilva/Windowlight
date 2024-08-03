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

    /**
     * Get the preset background color options.
     *
     * @return array<string, string> An associative array of color names and hex values.
     */
    public static function getBackgroundColors(): array
    {
        return [
            'White' => '#FFFFFF',
            'Light Gray' => '#F3F4F6',
            'Dark Gray' => '#1F2937',
            'Almost Black' => '#111827',
            'Blue' => '#3B82F6',
            'Green' => '#10B981',
            'Red' => '#EF4444',
            'Yellow' => '#F59E0B',
            'Purple' => '#8B5CF6',
            'Transparent' => 'transparent',
        ];
    }

    /**
     * Converts HSL color values to hexadecimal color code.
     *
     * This function takes HSL (Hue, Saturation, Lightness) color values and
     * converts them to the corresponding hexadecimal color code.
     *
     * @param  int  $h  Hue value (0-360)
     * @param  int  $s  Saturation value (0-100)
     * @param  int  $l  Lightness value (0-100)
     * @return string Hexadecimal color code (e.g., "#40bfbf")
     *
     * @example $hex = hslToHex(180, 50, 50);  echo $hex; // Output: #40bfbf
     */
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

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
