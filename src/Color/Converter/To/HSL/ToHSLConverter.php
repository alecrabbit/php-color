<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSL;

use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AToConverter;

class ToHSLConverter extends AToConverter
{
    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        return IHSLColor::class;
    }
}
