<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\ICoreConverter;
use AlecRabbit\Color\Converter\DTO\DRGB as RGB;

class CoreConverter implements ICoreConverter
{
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
}
