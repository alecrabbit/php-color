<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\Hex;

use AlecRabbit\Color\Converter\A\AToConverter;

class ToHexConverter extends AToConverter
{
    protected static function getTargets(): iterable
    {
        return [];
    }
}
