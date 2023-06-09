<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface ICoreConverter
{
    public function hslToRgb(int $hue, float $saturation, float $lightness): array;
}
