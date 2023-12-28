<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator\A;

use function strtolower;
use function trim;

abstract class AInstantiator
{
    protected static function normalize(string $color): string
    {
        return strtolower(trim($color));
    }

    public static function isSupported(string $color): bool
    {
        $color = self::normalize($color);

        return static::canInstantiate($color);
    }

    abstract protected static function canInstantiate(string $color): bool;
}
