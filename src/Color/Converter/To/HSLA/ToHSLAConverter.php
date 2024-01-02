<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSLA;

use AlecRabbit\Color\Converter\A\AToConverter;

class ToHSLAConverter extends AToConverter
{
    protected static function getTargets(): iterable
    {
        return [];
    }
}
