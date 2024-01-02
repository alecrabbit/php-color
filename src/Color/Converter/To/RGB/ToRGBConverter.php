<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGB;

use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AToConverter;

class ToRGBConverter extends AToConverter
{
    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        return IRGBColor::class;
    }
}
