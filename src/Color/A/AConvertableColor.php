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
        return self::getFromString($color);
    }

    protected static function getFromString(string $color): IConvertableColor
    {
        return Instantiator::fromString($color);
    }

    public static function from(IConvertableColor $color): IConvertableColor
    {
        return self::convert($color, static::class);
    }

    public function to(string $class): IConvertableColor
    {
        return self::convert($this, $class);
    }

    /**
     * @param IConvertableColor $color
     * @param class-string<IConvertableColor> $to
     *
     * @return IConvertableColor
     */
    protected static function convert(IConvertableColor $color, string $to): IConvertableColor
    {
        return Converter::to($to)->convert($color);
    }

    abstract public function toString(): string;
}
