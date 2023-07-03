<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Util\Converter;
use AlecRabbit\Color\Util\Instantiator;

abstract class AConvertableColor implements IConvertableColor
{
    protected const COMPONENT = 0xFF;

    public static function fromString(string $color): IConvertableColor
    {
        return Instantiator::fromString($color);
    }

    public function to(string $class): IConvertableColor
    {
        return Converter::to($class)->convert($this);
    }

    abstract public function toString(): string;
}
