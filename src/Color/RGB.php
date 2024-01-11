<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\ARGBValueColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Model\DTO\DRGB;

use function sprintf;

class RGB extends ARGBValueColor implements IRGBColor
{
    public static function fromString(string $value): IRGBColor
    {
        return parent::getFromString($value)->to(IRGBColor::class);
    }

    public static function from(IColor $color): IRGBColor
    {
        return $color->to(IRGBColor::class);
    }

    public static function fromDTO(IColorDTO $dto): IRGBColor
    {
        /** @var DRGB $dto */
        return self::fromRGB(
            (int)round($dto->red * self::COMPONENT),
            (int)round($dto->green * self::COMPONENT),
            (int)round($dto->blue * self::COMPONENT),
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
