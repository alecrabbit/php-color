<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\A;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\IConvertableColor;

abstract class AFromConverter implements IFromConverter
{
    public function convert(IConvertableColor $color): IConvertableColor
    {
        static::assertColor($color);
        return
            static::createColor($color);
    }

    abstract protected static function assertColor(mixed $color): void;

    abstract protected static function createColor(IConvertableColor $color): IConvertableColor;
}
