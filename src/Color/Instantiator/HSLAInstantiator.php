<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;

/**
 * @extends AInstantiator<IHSLAColor>
 */
class HSLAInstantiator extends AInstantiator
{
    protected const REGEXP_HSLA = '/^hsla?\((\d+)(?:,\s*|\s*)(\d+)%(?:,\s*|\s*)(\d+)%(?:(?:,\s*|\s*\/\s*)(([\d.]+)|(\d+%)))?\)$/';

    /** @inheritDoc */
    protected function createFromString(string $value): ?IColor
    {
        if (self::canInstantiateFromString($value, $matches)) {
            return
                HSLA::fromHSLA(
                    (int)$matches[1],
                    round(((int)$matches[2]) / 100, $this->precision),
                    round(((int)$matches[3]) / 100, $this->precision),
                    isset($matches[4])
                        ? $this->extractOpacity($matches[4])
                        : 1.0,
                );
        }

        return null;
    }

    protected static function canInstantiateFromString(string $value, &$matches = null): bool
    {
        return
            (
                str_starts_with($value, 'hsla(')
                ||
                (str_starts_with($value, 'hsl(') && str_contains($value, '/'))
            ) && preg_match(self::REGEXP_HSLA, $value, $matches);
    }

    private function extractOpacity(string $value): float
    {
        if (str_contains($value, '%')) {
            return round(((int)$value) / 100, $this->precision);
        }

        return round((float)$value, $this->precision);
    }

    protected function createFromDTO(DColor $value): ?IColor
    {
        if (self::canInstantiateFromDTO($value)) {
            /** @var DHSL $value */
            return HSLA::fromHSLA(
                (int)round($value->hue * 360),
                $value->saturation,
                $value->lightness,
                $value->alpha,
            );
        }

        return null;
    }

    protected static function canInstantiateFromDTO(DColor $color): bool
    {
        return $color instanceof DHSL;
    }
}
