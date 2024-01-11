<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Color\Util\Converter;

abstract class AColor implements IColor
{
    protected const COMPONENT = 0xFF;

    public function __construct(
        protected readonly IColorModel $colorModel
    ) {
    }

    abstract public static function from(IColor $color): IColor;

    /**
     * @param IColor $color
     * @param class-string<IColor> $to
     *
     * @return IColor
     */
    protected static function convert(IColor $color, string $to): IColor
    {
        if ($color::class === $to) {
            return $color;
        }

        return Converter::to($to)->convert($color);
    }

    public function to(string $class): IColor
    {
        return self::convert($this, $class);
    }

    protected static function getFromString(string $color): IColor
    {
        return Color::fromString($color);
    }

    abstract public static function fromString(string $value): IColor;

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
