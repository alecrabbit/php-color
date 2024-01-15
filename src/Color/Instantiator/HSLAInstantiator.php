<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @extends AInstantiator<IHSLAColor>
 */
class HSLAInstantiator extends AInstantiator
{
    protected const REGEXP_HSLA = '/^hsla?\((\d+)(?:,\s*|\s*)(\d+)%(?:,\s*|\s*)(\d+)%(?:(?:,\s*|\s*\/\s*)(([\d.]+)|(\d+%)))?\)$/';

    public static function getTargetClass(): string
    {
        return HSLA::class;
    }

    /** @inheritDoc */
    protected function createFromString(string $value): ?IColor
    {
        if (self::canInstantiate($value) && preg_match(self::REGEXP_HSLA, $value, $matches)) {
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

    protected function createFromDTO(DColor $value): ?IColor
    {
        // TODO: Implement createFromDTO() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
