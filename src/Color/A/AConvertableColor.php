<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IConvertableColor;

abstract class AConvertableColor implements IConvertableColor
{

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IColor
    {
        // TODO: Implement fromRGBO() method.
    }

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = self::SEGMENT): IColor
    {
        // TODO: Implement fromRGBA() method.
    }

    public function getValue(): int
    {
        // TODO: Implement getValue() method.
    }

    public function getAlpha(): int
    {
        // TODO: Implement getAlpha() method.
    }

    public function getRed(): int
    {
        // TODO: Implement getRed() method.
    }

    public function getGreen(): int
    {
        // TODO: Implement getGreen() method.
    }

    public function getBlue(): int
    {
        // TODO: Implement getBlue() method.
    }

    public function getOpacity(): float
    {
        // TODO: Implement getOpacity() method.
    }

    public function toHex(): IConvertableColor
    {
        // TODO: Implement toHex() method.
    }

    public function toHSL(): IConvertableColor
    {
        // TODO: Implement toHSL() method.
    }

    public function toHSLA(): IConvertableColor
    {
        // TODO: Implement toHSLA() method.
    }

    public function toRGB(): IConvertableColor
    {
        // TODO: Implement toRGB() method.
    }

    public function toRGBA(): IConvertableColor
    {
        // TODO: Implement toRGBA() method.
    }

    public function toYUV(): IConvertableColor
    {
        // TODO: Implement toYUV() method.
    }

    public function toCMYK(): IConvertableColor
    {
        // TODO: Implement toCMYK() method.
    }

    public function toXYZ(): IConvertableColor
    {
        // TODO: Implement toXYZ() method.
    }

    public function toLAB(): IConvertableColor
    {
        // TODO: Implement toLAB() method.
    }

    public function toLCh(): IConvertableColor
    {
        // TODO: Implement toLCh() method.
    }

    public function toHCL(): IConvertableColor
    {
        // TODO: Implement toHCL() method.
    }

    public function toHSV(): IConvertableColor
    {
        // TODO: Implement toHSV() method.
    }

    public function toHSVA(): IConvertableColor
    {
        // TODO: Implement toHSVA() method.
    }

    public function toYIQ(): IConvertableColor
    {
        // TODO: Implement toYIQ() method.
    }

    public function toGrayscale(): IConvertableColor
    {
        // TODO: Implement toGrayscale() method.
    }

    public function toPantone(): IConvertableColor
    {
        // TODO: Implement toPantone() method.
    }
}
