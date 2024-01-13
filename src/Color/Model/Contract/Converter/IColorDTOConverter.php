<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IColorDTOConverter
{
    public function convert(DColor $color): DColor;
}
