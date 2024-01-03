<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\ARGBValueColor;
use AlecRabbit\Color\Contract\IHexColor;

use function abs;
use function sprintf;

class Hex extends ARGBValueColor implements IHexColor
{
    /** @psalm-suppress MoreSpecificReturnType */
    public static function fromString(string $color): IHexColor
    {
        /**
         * @noinspection PhpIncompatibleReturnTypeInspection
         * @psalm-suppress LessSpecificReturnStatement
         */
        return parent::fromString($color)->to(self::class);
    }

    public static function fromInteger(int $value): IHexColor
    {
        return new self(abs($value) & (int)static::MAX);
    }

    public function toString(): string
    {
        return sprintf((string)static::FORMAT_HEX, $this->getValue());
    }

    public function withRed(int $red): IHexColor
    {
        return self::fromRGB($red, $this->getGreen(), $this->getBlue());
    }

    public static function fromRGB(int $r, int $g, int $b): IHexColor
    {
        return
            new self(
                self::componentsToValue($r, $g, $b),
            );
    }

    public function withGreen(int $green): IHexColor
    {
        return self::fromRGB($this->getRed(), $green, $this->getBlue());
    }

    public function withBlue(int $blue): IHexColor
    {
        return self::fromRGB($this->getRed(), $this->getGreen(), $blue);
    }
}
