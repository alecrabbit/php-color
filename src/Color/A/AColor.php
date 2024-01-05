<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Util\Converter;
use AlecRabbit\Color\Util\Instantiator;

abstract class AColor implements IColor
{
    protected const COMPONENT = 0xFF;

    public function __construct(
        protected readonly IColorModel $colorModel
    ) {
    }

    public static function fromString(string $color): IColor
    {
        return self::getFromString($color);
    }

    protected static function getFromString(string $color): IColor
    {
        return Instantiator::fromString($color);
    }

    public static function from(IColor $color): IColor
    {
        return self::convert($color, static::class);
    }

    /**
     * @param IColor $color
     * @param class-string<IColor> $to
     *
     * @return IColor
     */
    protected static function convert(IColor $color, string $to): IColor
    {
        return Converter::to($to)->convert($color);
    }

    public function to(string $class): IColor
    {
        return self::convert($this, $class);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    abstract public function toString(): string;

    public function getColorModel(): IColorModel
    {
        return $this->colorModel;
    }
}
