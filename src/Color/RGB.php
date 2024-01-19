<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\ARGBValueColor;
use AlecRabbit\Color\Contract\IRGBColor;

use function sprintf;

class RGB extends ARGBValueColor implements IRGBColor
{
    public function withRed(int $red): IRGBColor
    {
        return self::fromRGB($red, $this->getGreen(), $this->getBlue());
    }

    public static function fromRGB(int $r, int $g, int $b): IRGBColor
    {
        return
            new self(
                self::componentsToValue($r, $g, $b),
            );
    }

    public function withGreen(int $green): IRGBColor
    {
        return self::fromRGB($this->getRed(), $green, $this->getBlue());
    }

    public function withBlue(int $blue): IRGBColor
    {
        return self::fromRGB($this->getRed(), $this->getGreen(), $blue);
    }

    public function toString(): string
    {
        return
            sprintf(
                (string)static::FORMAT_RGB,
                $this->getRed(),
                $this->getGreen(),
                $this->getBlue(),
            );
    }
}
