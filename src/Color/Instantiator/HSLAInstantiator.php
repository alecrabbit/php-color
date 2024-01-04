<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\A\AInstantiator;

class HSLAInstantiator extends AInstantiator
{
    protected const REGEXP_HSLA = '/^hsla?\((\d+)(?:,\s*|\s*)(\d+)%(?:,\s*|\s*)(\d+)%(?:(?:,\s*|\s*\/\s*)(([\d.]+)|(\d+%)))?\)$/';
    protected const PRECISION = 2;

    protected function instantiate(string $color): ?IConvertableColor
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
