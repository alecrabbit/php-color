<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColorConverter
{
    public static function fromString(string $color): IConvertableColor;

    public function toRGB(IConvertableColor $color): IConvertableColor;

    public function toRGBA(IConvertableColor $color): IConvertableColor;

    public function toHex(IConvertableColor $color): IConvertableColor;
}
