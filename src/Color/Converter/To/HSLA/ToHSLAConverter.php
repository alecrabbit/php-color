<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSLA;

use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Converter\A\AToConverter;

class ToHSLAConverter extends AToConverter
{
    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        return IHSLAColor::class;
    }
}
