<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\ICoreConverter;

class CoreConverter implements ICoreConverter
{
    public function hslToRgb(int $h, float $s, float $l): array
    {
        return [0, 0, 0];
    }
}
