<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSL;

use AlecRabbit\Color\Converter\A\AToConverter;

class ToHSLConverter extends AToConverter
{
    protected static function getTargets(): iterable
    {
        return [];
    }
}
