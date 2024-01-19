<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IPartialConverter extends IColorConverter
{
    public function convert(IColor $color): DColor;
}
