<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Instantiator\A\AInstantiator;

class HSLInstantiator extends AInstantiator
{
    protected const REGEXP_HSL = '/^hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)$/';
    protected const PRECISION = 2;

    protected function instantiate(string $color): ?IConvertableColor
    {
        if (self::canInstantiate($color) && preg_match(self::REGEXP_HSL, $color, $matches)) {
            return
                HSL::fromHSL(
                    (int)$matches[1],
                    round(((int)$matches[2]) / 100, self::PRECISION),
                    round(((int)$matches[3]) / 100, self::PRECISION),
                );
        }

        return null;
    }

    protected static function canInstantiate(string $color): bool
    {
        return str_contains($color, 'hsl(');
    }
}
