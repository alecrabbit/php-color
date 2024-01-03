<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGB;

use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\RGB;
use ArrayObject;
use Traversable;

class ToRGBConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): Traversable
    {
        return new ArrayObject([RGB::class, IRGBColor::class]);
    }
}
