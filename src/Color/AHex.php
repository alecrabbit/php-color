<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IAHexColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;

use function abs;
use function sprintf;

class AHex extends Hex implements IAHexColor
{
    protected const MAX_NO_ALPHA = 0x00FFFFFF;
    protected const ALPHA = 0xFF000000;

    protected function __construct(
        int $value,
        protected readonly int $alpha,
    ) {
        parent::__construct($value);
    }

    public static function fromInteger(int $value): IAHexColor
    {
        return new self($value & self::MAX_NO_ALPHA, ($value & self::ALPHA) >> 24);
    }

    protected static function fromDTO(DColor $dto): IColor
    {
        /** @var DRGB $dto */
        return self::fromRGBA(
            (int)round($dto->r * 0xFF),
            (int)round($dto->g * 0xFF),
            (int)round($dto->b * 0xFF),
            (int)round($dto->alpha * 0xFF),
        );
    }

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = 0xFF): IAHexColor
    {
        return
            new self(
                self::componentsToValue($r, $g, $b),
                (abs($alpha) & self::COMPONENT)
            );
    }

    public function toString(): string
    {
        return sprintf((string)static::FORMAT_AHEX, $this->getAlpha(), $this->getValue());
    }

    public function getAlpha(): int
    {
        return $this->alpha;
    }

    public function withRed(int $red): IAHexColor
    {
        return self::fromRGB($red, $this->getGreen(), $this->getBlue());
    }

    public static function fromRGB(int $r, int $g, int $b): IAHexColor
    {
        return
            new self(
                self::componentsToValue($r, $g, $b),
                0xFF,
            );
    }

    public function withGreen(int $green): IAHexColor
    {
        return self::fromRGB($this->getRed(), $green, $this->getBlue());
    }

    public function withBlue(int $blue): IAHexColor
    {
        return self::fromRGB($this->getRed(), $this->getGreen(), $blue);
    }

    public function getOpacity(): float
    {
        return round($this->getAlpha() / self::COMPONENT, self::CALC_PRECISION);
    }

    public function withAlpha(int $alpha): IAHexColor
    {
        return
            self::fromRGBA($this->getRed(), $this->getGreen(), $this->getBlue(), $alpha);
    }

    public function withOpacity(float $opacity): IAHexColor
    {
        return
            self::fromRGBO($this->getRed(), $this->getGreen(), $this->getBlue(), $opacity);
    }

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IAHexColor
    {
        $alpha = (int)(abs($opacity) * self::COMPONENT) & self::COMPONENT;

        return
            self::fromRGBA($r, $g, $b, $alpha);
    }

    public function getValue8(): int
    {
        return $this->getAlpha() << 24 | $this->getValue();
    }
}
