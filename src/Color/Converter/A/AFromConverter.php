<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\A;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\IColor;

abstract class AFromConverter implements IFromConverter
{
    abstract protected static function getSources(): iterable;

    public function convert(IColor $color): IColor
    {
        static::assertColor($color);
        return
            static::createColor($color);
    }

    abstract protected static function assertColor(mixed $color): void;

    abstract protected static function createColor(IColor $color): IColor;
}
