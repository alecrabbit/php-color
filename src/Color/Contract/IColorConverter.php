<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColorConverter
{
    public function toRGB(IConvertableColor $color): IConvertableColor;

    public function toRGBA(IConvertableColor $color): IConvertableColor;
}
