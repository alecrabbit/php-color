<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\Hex;

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Hex;

class ToHexConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): \Traversable
    {
        return new \ArrayObject([Hex::class, IHexColor::class]);
    }
}
