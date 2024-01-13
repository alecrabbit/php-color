<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Instantiator\A\AInstantiator;

/**
 * @extends AInstantiator<IHSLColor>
 */
class HSLInstantiator extends AInstantiator
{
    protected const REGEXP_HSLA = '/^hsla?\((\d+)(?:,\s*|\s*)(\d+)%(?:,\s*|\s*)(\d+)%(?:(?:,\s*|\s*\/\s*)(([\d.]+)|(\d+%)))?\)$/';
    protected const PRECISION = 2;

    public static function getTargetClass(): string
    {
        return HSL::class;
    }

    /** @inheritDoc */
    protected function createFromString(string $value): ?IColor
    {
        if (self::canInstantiate($value) && preg_match(self::REGEXP_HSLA, $value, $matches)) {
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
        return str_starts_with($color, 'hsl(') && !str_contains($color, '/');
    }
}
