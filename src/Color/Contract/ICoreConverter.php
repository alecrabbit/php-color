<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\DTO\DHSL;
use AlecRabbit\Color\DTO\DRGB;

interface ICoreConverter
{
    public function hslToRgb(int $hue, float $saturation, float $lightness): DRGB;

    public function rgbToHsl(int $red, int $green, int $blue): DHSL;
}
