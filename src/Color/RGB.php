<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\ARGBValueColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;

use function sprintf;

class RGB extends ARGBValueColor implements IRGBColor
{
    protected static function fromDTO(DColor $dto): IColor
    {
        /** @var DRGB $dto */
        return self::fromRGB(
            (int)round($dto->r * 0xFF),
            (int)round($dto->g * 0xFF),
            (int)round($dto->b * 0xFF),
        );
    }

    public static function fromRGB(int $r, int $g, int $b): IRGBColor
    {
        return
            new self(
                self::componentsToValue($r, $g, $b),
            );
    }

    public function withRed(int $red): IRGBColor
    {
        return self::fromRGB($red, $this->getGreen(), $this->getBlue());
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
