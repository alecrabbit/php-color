<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Core\Contract;

use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;

interface ICoreConverter
{
    public function hslToRgb(int $hue, float $saturation, float $lightness): DRGB;

    public function rgbToHsl(int $red, int $green, int $blue): DHSL;
}
