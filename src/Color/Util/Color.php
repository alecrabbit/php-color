<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\A\AColor;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Exception\ColorException;

/**
 * Utility class for convenient color instantiation.
 *
 * @codeCoverageIgnore
 */
final class Color extends AColor
{
    private function __construct()
    {
        // Can not be instantiated
    }

    public function toString(): string
    {
        throw new ColorException('Can not be called.');
    }

    public function getColorModel(): IColorModel
    {
        throw new ColorException('Can not be called.');
    }
}
