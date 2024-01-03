<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSL;

use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\HSL;

class ToHSLConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): iterable
    {
        return [HSL::class, IHSLColor::class];
    }
}
