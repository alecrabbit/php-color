<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Factory\InstantiatorFactory;
use AlecRabbit\Color\Util\Converter;

abstract class AConvertableColor implements IConvertableColor
{
    protected const COMPONENT = 0xFF;

    public static function fromString(string $color): IConvertableColor
    {
        return InstantiatorFactory::getInstantiator()->fromString($color);
    }

    public function to(string $class): IConvertableColor
    {
        return Converter::to($class)->convert($this);
    }

    abstract public function toString(): string;
}
