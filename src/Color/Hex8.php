<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IHex8Color;

use function abs;
use function sprintf;

class Hex8 extends Hex implements IHex8Color
{
    protected const MAX = 0xFFFFFF00;
    protected const PRECISION = 3;

    protected function __construct(
        int $value,
        protected readonly int $alpha,
    ) {
        parent::__construct($value);
    }

    /** @psalm-suppress MoreSpecificReturnType */
    public static function fromString(string $color): IHex8Color
    {
        /**
         * @noinspection PhpIncompatibleReturnTypeInspection
         * @psalm-suppress LessSpecificReturnStatement
         */
        return parent::fromString($color)->to(self::class);
    }

    public static function fromInteger(int $value): IHex8Color
    {
        return new self((abs($value) & (int)static::MAX) >> 8, $value & 0x000000FF);
    }

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = 0xFF): IHex8Color
    {
        return
            new self(
                self::componentsToValue($r, $g, $b),
                (abs($alpha) & self::COMPONENT)
            );
    }

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IHex8Color
    {
        $alpha = (int)(abs($opacity) * self::COMPONENT) & self::COMPONENT;

        return
            self::fromRGBA($r, $g, $b, $alpha);
    }

    public function toString(): string
    {
        return sprintf((string)static::FORMAT_HEX8, $this->getValue(), $this->getAlpha());
    }

    public function getAlpha(): int
    {
        return $this->alpha;
    }

    public function withRed(int $red): IHex8Color
    {
        return self::fromRGB($red, $this->getGreen(), $this->getBlue());
    }

    public static function fromRGB(int $r, int $g, int $b): IHex8Color
    {
        return
            new self(
                self::componentsToValue($r, $g, $b),
                0xFF,
            );
    }

    public function withGreen(int $green): IHex8Color
    {
        return self::fromRGB($this->getRed(), $green, $this->getBlue());
    }

    public function withBlue(int $blue): IHex8Color
    {
        return self::fromRGB($this->getRed(), $this->getGreen(), $blue);
    }

    public function getOpacity(): float
    {
        return round($this->getAlpha() / self::COMPONENT, self::PRECISION);
    }

    public function withAlpha(int $alpha): IHex8Color
    {
        // TODO: Implement withAlpha() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }

    public function withOpacity(float $opacity): IHex8Color
    {
        // TODO: Implement withOpacity() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
