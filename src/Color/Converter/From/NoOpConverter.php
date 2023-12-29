<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\From;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\IConvertableColor;

final class NoOpConverter implements IFromConverter
{
    public function convert(IConvertableColor $color): IConvertableColor
    {
        return $color;
    }
}
