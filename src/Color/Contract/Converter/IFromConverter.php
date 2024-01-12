<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IColor;

interface IFromConverter
{
    public function convert(IColor $color): IColor;
}
