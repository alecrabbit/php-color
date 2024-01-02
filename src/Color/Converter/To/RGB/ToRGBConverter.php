<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGB;

use AlecRabbit\Color\Converter\A\AToConverter;

class ToRGBConverter extends AToConverter
{
    protected static function getTargets(): iterable
    {
        return [];
    }
}
