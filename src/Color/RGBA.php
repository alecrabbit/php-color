<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IRGBAColor;

class RGBA extends RGB implements IRGBAColor
{
    protected const PRECISION = 3;

    protected function __construct(
        int $value,
        protected readonly int $alpha = self::COMPONENT,
    ) {
        parent::__construct($value);
    }

    public function withRed(int $red): IRGBAColor
    {
        return
            self::fromRGBA($red, $this->getGreen(), $this->getBlue(), $this->getAlpha());
    }

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = self::COMPONENT): IRGBAColor
    {
        return
            new self(
                self::componentsToInteger($r, $g, $b),
                (abs($alpha) & self::COMPONENT)
            );
    }

    public function getAlpha(): int
    {
        return $this->alpha;
    }

    public function withGreen(int $green): IRGBAColor
    {
        return
            self::fromRGBA($this->getRed(), $green, $this->getBlue(), $this->getAlpha());
    }

    public function withBlue(int $blue): IRGBAColor
    {
        return
            self::fromRGBA($this->getRed(), $this->getGreen(), $blue, $this->getAlpha());
    }

    public function toString(): string
    {
        return sprintf(
            self::FORMAT_RGBA,
            $this->getRed(),
            $this->getGreen(),
            $this->getBlue(),
            $this->getOpacity()
        );
    }

    public function getOpacity(): float
    {
        return round($this->getAlpha() / self::COMPONENT, self::PRECISION);
    }

    public function withAlpha(int $alpha): IRGBAColor
    {
        return
            self::fromRGBA($this->getRed(), $this->getGreen(), $this->getBlue(), $alpha);
    }

    public function withOpacity(float $opacity): IRGBAColor
    {
        return
            self::fromRGBO($this->getRed(), $this->getGreen(), $this->getBlue(), $opacity);
    }

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IRGBAColor
    {
        $alpha = (int)(abs($opacity) * self::COMPONENT) & self::COMPONENT;
        return
            self::fromRGBA($r, $g, $b, $alpha);
    }
}
