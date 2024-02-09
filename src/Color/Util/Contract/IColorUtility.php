<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util\Contract;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;

interface IColorUtility
{
    public static function from(mixed $value): IColor;

    public static function tryFrom(mixed $value): ?IColor;
}
