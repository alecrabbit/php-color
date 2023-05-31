<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IRGBColor;

use function abs;
use function sprintf;

class RGB extends AConvertableColor implements IRGBColor
{
    protected const MAX = 0xFFFFFF;
    protected const COMPONENT = 0xFF;
    protected const RED = 0xFF0000;
    protected const GREEN = 0x00FF00;
    protected const BLUE = 0x0000FF;

    protected function __construct(
        protected readonly int $value,
    ) {
    }

    /** @psalm-suppress MoreSpecificReturnType */
    public static function fromString(string $color): IRGBColor
    {
        /**
         * @noinspection PhpIncompatibleReturnTypeInspection
         * @psalm-suppress LessSpecificReturnStatement
         */
        return parent::fromString($color)->toRGB();
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function withRed(int $red): IRGBColor
    {
        return self::fromRGB($red, $this->getGreen(), $this->getBlue());
    }

    public static function fromRGB(int $r, int $g, int $b): IRGBColor
    {
        return
            new self(
                self::componentsToInteger($r, $g, $b),
            );
    }

    protected static function componentsToInteger(int $r, int $g, int $b): int
    {
        return (
                ((abs($r) & self::COMPONENT) << 16) |
                ((abs($g) & self::COMPONENT) << 8) |
                ((abs($b) & self::COMPONENT) << 0)
            ) & self::MAX;
    }

    public function getGreen(): int
    {
        return (self::GREEN & $this->value) >> 8;
    }

    public function getBlue(): int
    {
        return (self::BLUE & $this->value) >> 0;
    }

    public function withGreen(int $green): IRGBColor
    {
        return self::fromRGB($this->getRed(), $green, $this->getBlue());
    }

    public function getRed(): int
    {
        return (self::RED & $this->value) >> 16;
    }

    public function withBlue(int $blue): IRGBColor
    {
        return self::fromRGB($this->getRed(), $this->getGreen(), $blue);
    }

    public function toString(): string
    {
        return
            sprintf(
                self::FORMAT_RGB,
                $this->getRed(),
                $this->getGreen(),
                $this->getBlue(),
            );
    }
}
