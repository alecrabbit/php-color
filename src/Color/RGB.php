<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBColor;

class RGB extends AConvertableColor implements IRGBColor
{
    private const MAX = 0xFFFFFF;
    private const COMPONENT = 0xFF;
    private const PRECISION = 3;
    private const RED = 0xFF0000;
    private const GREEN = 0x00FF00;
    private const BLUE = 0x0000FF;

    protected function __construct(
        private readonly int $value,
        private readonly int $alpha = self::COMPONENT,
    ) {
    }

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IColor
    {
        return
            self::fromRGBA(
                $r,
                $g,
                $b,
                (int)(abs($opacity) * self::COMPONENT) & self::COMPONENT
            );
    }

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = self::COMPONENT): IColor
    {
        return
            new self(
                self::componentsToInteger($r, $g, $b),
                (abs($alpha) & self::COMPONENT)
            );
    }

    private static function componentsToInteger(int $r, int $g, int $b): int
    {
        return (
                ((abs($r) & self::COMPONENT) << 16) |
                ((abs($g) & self::COMPONENT) << 8) |
                ((abs($b) & self::COMPONENT) << 0)
            ) & self::MAX;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getOpacity(): float
    {
        return round($this->getAlpha() / self::COMPONENT, self::PRECISION);
    }

    public function getAlpha(): int
    {
        return $this->alpha;
    }

    public function getRed(): int
    {
        return (self::RED & $this->value) >> 16;
    }

    public function getGreen(): int
    {
        return (self::GREEN & $this->value) >> 8;
    }

    public function getBlue(): int
    {
        return (self::BLUE & $this->value) >> 0;
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
