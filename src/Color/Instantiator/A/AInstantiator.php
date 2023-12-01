<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator\A;

abstract class AInstantiator
{
    protected static function normalize(string $color): string
    {
        return strtolower($color);
    }
}
