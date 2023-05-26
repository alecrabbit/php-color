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
}
