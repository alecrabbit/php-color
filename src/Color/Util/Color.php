<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Exception\ColorException;

/**
 * Utility class for convenient color instantiation.
 *
 * @codeCoverageIgnore Coverage does not make sense.
 */
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
