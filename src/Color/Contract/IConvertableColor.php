<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IConvertableColor extends IColor
{
    public function toHex(): IConvertableColor;

    public function toHSL(): IConvertableColor;

    public function toHSLA(): IConvertableColor;

    public function toRGB(): IConvertableColor;

    public function toRGBA(): IConvertableColor;

    public function toYUV(): IConvertableColor;

    public function toCMYK(): IConvertableColor;

    public function toXYZ(): IConvertableColor;

    public function toLAB(): IConvertableColor;

    public function toLCh(): IConvertableColor;
    public function toHCL(): IConvertableColor;

    public function toHSV(): IConvertableColor;

    public function toHSVA(): IConvertableColor;

    public function toYIQ(): IConvertableColor;

    public function toGrayscale(): IConvertableColor;

    public function toPantone(): IConvertableColor;
}
