<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Exception\ColorException;

final class Color extends AConvertableColor
{
    private function __construct()
    {
        // Can not be instantiated
    }

    public function toString(): string
    {
        throw new ColorException('Can not be called.');
    }
}
