<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;

use function abs;
use function sprintf;

class Hex extends AConvertableColor implements IHexColor
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
    public static function fromString(string $color): IHexColor
    {
        /**
         * @noinspection PhpIncompatibleReturnTypeInspection
         * @psalm-suppress LessSpecificReturnStatement
         */
        return parent::fromString($color)->toHex();
    }

    public function toString(): string
    {
        return sprintf(self::FORMAT_HEX, $this->getValue());
    }

    public function getValue(): int
    {
        return $this->value;
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

    protected static function componentsToValue(int $r, int $g, int $b): int
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

    public function withGreen(int $green): IHexColor
    {
        return self::fromInteger(
            self::componentsToValue($this->getRed(), $green, $this->getBlue())
        );
    }

    public function getRed(): int
    {
        return (self::RED & $this->value) >> 16;
    }

    public function withBlue(int $blue): IHexColor
    {
        return self::fromInteger(
            self::componentsToValue($this->getRed(), $this->getGreen(), $blue)
        );
    }
}
