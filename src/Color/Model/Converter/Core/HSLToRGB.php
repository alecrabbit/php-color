<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Model\DTO\DHSL as HSL;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;

final readonly class HSLToRGB extends ACoreConverter
{
    protected static function inputType(): string
    {
        return HSL::class;
    }

    protected function doConvert(IColorDTO $color): IColorDTO
    {
        /** @var HSL $color */
        $h = $color->hue / 360;
        $c = (1 - abs(2 * $color->lightness - 1)) * $color->saturation;
        $x = $c * (1 - abs(fmod($h * 6, 2) - 1));
        $m = $color->lightness - $c / 2;

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
                round($color->alpha, $this->precision),
            );
    }
}
