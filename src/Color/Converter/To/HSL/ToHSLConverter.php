<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSL;

use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\HSL;

class ToHSLConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): \Traversable
    {
        return new \ArrayObject([HSL::class, IHSLColor::class]);
    }
}
