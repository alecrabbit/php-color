<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\ARGBValueColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;

use function abs;
use function sprintf;

class Hex extends ARGBValueColor implements IHexColor
{
    public static function fromString(string $value): IHexColor
    {
        return self::getFromString($value)->to(IHexColor::class);
    }

    public static function from(mixed $color): IHexColor
    {
        return $color->to(IHexColor::class);
    }

    public static function fromInteger(int $value): IHexColor
    {
        return new self(abs($value) & (int)static::MAX);
    }

    protected static function createFromDTO(DColor $dto): IHexColor
    {
        /** @var DRGB $dto */
        return self::fromRGB(
            (int)round($dto->red * self::COMPONENT),
            (int)round($dto->green * self::COMPONENT),
            (int)round($dto->blue * self::COMPONENT),
        );
    }

    public static function fromRGB(int $r, int $g, int $b): IHexColor
    {
        return
            new self(
                self::componentsToValue($r, $g, $b),
            );
    }

    public function toString(): string
    {
        return sprintf((string)static::FORMAT_HEX, $this->getValue());
    }

    public function withRed(int $red): IHexColor
    {
        return self::fromRGB($red, $this->getGreen(), $this->getBlue());
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
