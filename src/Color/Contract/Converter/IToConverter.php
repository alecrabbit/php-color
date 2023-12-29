<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;

interface IToConverter
{
    public function convert(IConvertableColor $color): IConvertableColor;
}
