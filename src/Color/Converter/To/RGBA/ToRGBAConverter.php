<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGBA;

use AlecRabbit\Color\Converter\A\AToConverter;

class ToRGBAConverter extends AToConverter
{
    protected static function getTargets(): iterable
    {
        return [];
    }
}
