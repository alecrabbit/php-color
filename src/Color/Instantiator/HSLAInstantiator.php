<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\HSLA;

class HSLAInstantiator extends HSLInstantiator
{
    protected function instantiate(string $color): ?IColor
    {
        if (self::canInstantiate($color) && preg_match(self::REGEXP_HSLA, $color, $matches)) {
            return
                HSLA::fromHSLA(
                    (int)$matches[1],
                    round(((int)$matches[2]) / 100, self::PRECISION),
                    round(((int)$matches[3]) / 100, self::PRECISION),
                    isset($matches[4])
                        ? self::extractOpacity($matches[4])
                        : 1.0,
                );
        }

        return null;
    }

    public static function getTargetClass(): string
    {
        return HSLA::class;
    }
    protected static function canInstantiate(string $color): bool
    {
        return
            str_starts_with($color, 'hsla(')
            ||
            (str_starts_with($color, 'hsl(') && str_contains($color, '/'));
    }

    private static function extractOpacity(string $value): float
    {
        if (str_contains($value, '%')) {
            return round(((int)$value) / 100, self::PRECISION);
        }

        return round((float)$value, self::PRECISION);
    }
}
