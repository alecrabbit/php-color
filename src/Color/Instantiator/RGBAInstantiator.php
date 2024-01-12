<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\RGBA;

use function str_starts_with;

class RGBAInstantiator extends AInstantiator
{
    protected const REGEXP_RGBA = '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/';

    protected function instantiate(string $color): ?IColor
    {
        if (self::canInstantiate($color) && preg_match(self::REGEXP_RGBA, $color, $matches)) {
            return
                RGBA::fromRGBO(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                    isset($matches[4]) ? (float)$matches[4] : 1.0,
                );
        }

        return null;
    }

    public static function getTargetClass(): string
    {
        return RGBA::class;
    }
    protected static function canInstantiate(string $color): bool
    {
        return str_starts_with($color, 'rgba(');
    }
}
