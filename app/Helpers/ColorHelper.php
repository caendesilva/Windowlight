<?php

namespace App\Helpers;

class ColorHelper
{
    protected const SATURATION_BASE = 80;
    protected const LIGHTNESS_BASE = 90;

    public static function generateColorScheme(int $count = 12, float $startHue = 0, float $endHue = 360): array
    {
        $colors = [];

        $hueRange = $endHue - $startHue;
        $needsOffset = abs($hueRange) < 360;
        $offset = $hueRange / ($count - ($needsOffset ? 1 : 0));

        for ($i = 0; $i < $count; $i++) {
            $hue = ($startHue + $offset * $i) % 360;
            $saturation = static::SATURATION_BASE;
            $lightness = static::LIGHTNESS_BASE;

            $colors[] = static::hslToHex($hue, $saturation, $lightness);
        }

        return $colors;
    }

    /**
     * Get the preset background color options.
     *
     * @return array<string, string> An associative array of color names and hex values.
     */
    public static function getBackgroundColors(): array
    {
        return [
            // Pastel palette
            'rose_petal' => '#fad1e6',
            'soft_pink' => '#fad1d1',
            'peach_cream' => '#fae6d1',
            'lemon_chiffon' => '#fafad1',
            'lime_zest' => '#e6fad1',
            'mint_frost' => '#d1fad1',
            'aqua_mist' => '#d1fae6',
            'sky_blue' => '#d1fafa',
            'powder_blue' => '#d1e6fa',
            'periwinkle_mist' => '#d1d1fa',
            'lilac_haze' => '#e6d1fa',
            'orchid_blush' => '#fad1fa',

            // Base colors
            'white' => '#ffffff',
            'light_gray' => '#f3f4f6',
            'mid_gray' => '#e5e7eb',
            'dark_gray' => '#1f2937',
            'almost_black' => '#111827',
            'transparent' => 'transparent',
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

    /**
     * Determines if a given hex color is dark or light.
     *
     * This implementation calculates the relative luminance of the color based on the RGB values.
     * If the luminance is less than 0.5, the color is considered dark, and the function returns true.
     * Otherwise, it returns false.
     *
     * This approach provides a good balance between simplicity and accuracy for determining
     * whether a color is dark or light. It takes into account the human eye's different
     * sensitivities to red, green, and blue light.
     *
     * @param  string  $hex  The hex color code to check (with or without the leading '#')
     * @return bool True if the color is dark, false if it's light
     */
    public static function isColorDark(string $hex): bool
    {
        // Remove # if present
        $hex = ltrim($hex, '#');

        if (strlen($hex) !== 6) {
            // Invalid color value
            return false;
        }

        // Convert hex to RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Calculate relative luminance
        $luminance = (0.2126 * $r + 0.7152 * $g + 0.0722 * $b) / 255;

        // Return true if the color is dark (luminance is less than 0.5)
        return $luminance < 0.5;
    }
}
