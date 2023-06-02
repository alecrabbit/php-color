<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IConverter
{
    public function convert(IConvertableColor $color): IConvertableColor;
}
