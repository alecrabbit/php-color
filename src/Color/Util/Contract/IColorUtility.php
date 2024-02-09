<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util\Contract;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnsupportedValue;

interface IColorUtility
{
    /**
     * @param mixed $value Value to instantiate from.
     * @return IColor Instantiated color.
     *
     * @throws UnsupportedValue
     */
    public static function from(mixed $value): IColor;

    /**
     * @param mixed $value Value to try to instantiate from.
     * @return IColor|null Returns null if instantiation is not possible.
     */
    public static function tryFrom(mixed $value): ?IColor;
}
