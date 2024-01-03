<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGBA;

use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\RGBA;
use ArrayObject;
use Traversable;

class ToRGBAConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): Traversable
    {
        return new ArrayObject([RGBA::class, IRGBAColor::class]);
    }
}
