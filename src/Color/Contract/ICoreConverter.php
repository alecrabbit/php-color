<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Converter\DTO\DRGB;

interface ICoreConverter
{
    public function hslToRgb(int $hue, float $saturation, float $lightness): DRGB;
}
