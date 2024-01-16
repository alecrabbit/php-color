<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;
use RuntimeException;

/**
 * @extends AInstantiator<IHSLColor>
 */
class HSLInstantiator extends AInstantiator
{
    protected const REGEXP_HSLA = '/^hsla?\((\d+)(?:,\s*|\s*)(\d+)%(?:,\s*|\s*)(\d+)%(?:(?:,\s*|\s*\/\s*)(([\d.]+)|(\d+%)))?\)$/';

    /** @inheritDoc */
    public static function getTargetClass(): string
    {
        return HSL::class;
    }

    /** @inheritDoc */
    protected function createFromString(string $value): ?IColor
    {
        if (self::canInstantiateFromString($value) && preg_match(self::REGEXP_HSLA, $value, $matches)) {
            return
                HSL::fromHSL(
                    (int)$matches[1],
                    round(((int)$matches[2]) / 100, self::PRECISION),
                    round(((int)$matches[3]) / 100, self::PRECISION),
                );
        }

        return null;
    }

    protected static function canInstantiateFromDTO(DColor $color): bool
    {
        return $color instanceof DHSL;
    }

    protected static function canInstantiateFromString(string $color): bool
    {
        return str_starts_with($color, 'hsl(') && !str_contains($color, '/');
    }

    protected function createFromDTO(DColor $value): ?IColor
    {
        return null;
    }
}
