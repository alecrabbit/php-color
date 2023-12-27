<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IFromConverter
{
    public function convert(IConvertableColor $color): IConvertableColor;
}
