<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\Hex;

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Converter\A\AToConverter;

class ToHexConverter extends AToConverter
{
    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        return IHexColor::class;
    }
}
