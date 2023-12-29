<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;

interface IFromConverter
{
    public function convert(IConvertableColor $color): IConvertableColor;
}
