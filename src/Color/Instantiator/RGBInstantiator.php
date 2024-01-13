<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\RGB;

use function str_starts_with;

class RGBInstantiator extends AInstantiator
{
    protected const REGEXP_RGB = '/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/';

    public static function getTargetClass(): string
    {
        return RGB::class;
    }

    protected function instantiate(string $value): ?IColor
    {
        if (self::canInstantiate($value) && preg_match(self::REGEXP_RGB, $value, $matches)) {
            return
                RGB::fromRGB(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                );
        }

        return null;
    }

    protected static function canInstantiate(string $color): bool
    {
        return str_starts_with($color, 'rgb(');
    }
}
