<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\From;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\IColor;

final class NoOpConverter implements IFromConverter
{
    public function convert(IColor $color): IColor
    {
        return $color;
    }
}
