<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\ICoreConverter;
use AlecRabbit\Color\DTO\DHSL as HSL;
use AlecRabbit\Color\DTO\DRGB as RGB;

class CoreConverter implements ICoreConverter
{
    private const FLOAT_PRECISION = 2;

    public function __construct(
        protected int $precision = self::FLOAT_PRECISION,
    ) {
    }

    public function hslToRgb(int $hue, float $saturation, float $lightness): RGB
    {
        $h = $hue / 360;
        $c = (1 - abs(2 * $lightness - 1)) * $saturation;
        $x = $c * (1 - abs(fmod($h * 6, 2) - 1));
        $m = $lightness - $c / 2;

        $r = 0;
        $g = 0;
        $b = 0;

        match (true) {
            $h < 1 / 6 => [$r, $g] = [$c, $x],
            $h < 2 / 6 => [$r, $g] = [$x, $c],
            $h < 3 / 6 => [$g, $b] = [$c, $x],
            $h < 4 / 6 => [$g, $b] = [$x, $c],
            $h < 5 / 6 => [$r, $b] = [$x, $c],
            default => [$r, $b] = [$c, $x],
        };
        return
            new RGB(
                (int)round(($r + $m) * 255),
                (int)round(($g + $m) * 255),
                (int)round(($b + $m) * 255),
            );
    }

    public function rgbToHsl(int $red, int $green, int $blue): HSL
    {
        $r = $red / 255;
        $g = $green / 255;
        $b = $blue / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $h = 0;
        $s = 0;
        $l = ($max + $min) / 2;

        if ($max !== $min) {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

            switch ($max) {
                case $r:
                    $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
                    break;
                case $g:
                    $h = ($b - $r) / $d + 2;
                    break;
                case $b:
                    $h = ($r - $g) / $d + 4;
                    break;
            }

            $h /= 6;
        }

        return new HSL(
            (int)round($h * 360),
            round($s, $this->precision),
            round($l, $this->precision),
        );
    }
}
