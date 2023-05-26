<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBColor;

class RGB extends AConvertableColor implements IRGBColor
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = abs($value) & self::MAX;
    }

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IColor
    {
        $value =
            (
                (((int)(abs($opacity) * self::SEGMENT) & self::SEGMENT) << 24) |
                ((abs($r) & self::SEGMENT) << 16) |
                ((abs($g) & self::SEGMENT) << 8) |
                ((abs($b) & self::SEGMENT) << 0)
            ) & self::MAX;

        return
            new self($value);
    }

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = self::SEGMENT): IColor
    {
        $value =
            (
                ((abs($alpha) & self::SEGMENT) << 24) |
                ((abs($r) & self::SEGMENT) << 16) |
                ((abs($g) & self::SEGMENT) << 8) |
                ((abs($b) & self::SEGMENT) << 0)
            ) & self::MAX;

        return
            new self($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getOpacity(): float
    {
        return round($this->getAlpha() / self::SEGMENT, self::PRECISION);
    }

    public function getAlpha(): int
    {
        return (0xFF000000 & $this->value) >> 24;
    }

    public function getRed(): int
    {
        return (0x00FF0000 & $this->value) >> 16;
    }

    public function getGreen(): int
    {
        return (0x0000FF00 & $this->value) >> 8;
    }

    public function getBlue(): int
    {
        return (0x000000FF & $this->value) >> 0;
    }

    public function withRed(int $red): IRGBColor
    {
        // TODO: Implement withRed() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function withGreen(int $green): IRGBColor
    {
        // TODO: Implement withGreen() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function withBlue(int $blue): IRGBColor
    {
        // TODO: Implement withBlue() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function toString(): string
    {
        // TODO: Implement toString() method.
        throw new \RuntimeException('Not implemented.');
    }
}
