<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\Hex8;

use AlecRabbit\Color\Contract\IHex8Color;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Hex8;
use ArrayObject;
use Traversable;

class ToHex8Converter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): Traversable
    {
        return new ArrayObject([Hex8::class, IHex8Color::class]);
    }
}
