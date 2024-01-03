<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSLA;

use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\HSLA;
use ArrayObject;
use Traversable;

class ToHSLAConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): Traversable
    {
        return new ArrayObject([HSLA::class, IHSLAColor::class]);
    }
}
