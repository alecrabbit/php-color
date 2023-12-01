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

    public function toString(): string
    {
        return sprintf(self::FORMAT_HEX, $this->getValue());
    }

    public function withRed(int $red): IHexColor
    {
        return self::fromInteger(
            self::componentsToValue($red, $this->getGreen(), $this->getBlue())
        );
    }

    public static function fromInteger(int $value): IHexColor
    {
        return new self(abs($value) & self::MAX);
    }

    public function withGreen(int $green): IHexColor
    {
        return self::fromInteger(
            self::componentsToValue($this->getRed(), $green, $this->getBlue())
        );
    }

    public function withBlue(int $blue): IHexColor
    {
        return self::fromInteger(
            self::componentsToValue($this->getRed(), $this->getGreen(), $blue)
        );
    }
}
