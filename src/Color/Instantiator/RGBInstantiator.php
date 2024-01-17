<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\RGB;

use function str_starts_with;

/**
 * @extends AInstantiator<IRGBColor>
 */
class RGBInstantiator extends AInstantiator
{
    protected const REGEXP_RGB = '/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/';

    protected static function canInstantiateFromDTO(DColor $color): bool
    {
        return $color instanceof DRGB;
    }

    /** @inheritDoc */
    protected function createFromString(string $value): ?IColor
    {
        if (self::canInstantiateFromString($value) && preg_match(self::REGEXP_RGB, $value, $matches)) {
            return
                RGB::fromRGB(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                );
        }

        return null;
    }

    protected static function canInstantiateFromString(string $color): bool
    {
        return str_starts_with($color, 'rgb(');
    }

    protected function createFromDTO(DColor $value): ?IColor
    {
        if (self::canInstantiateFromDTO($value)) {
            /** @var DRGB $value */
            return RGB::fromRGB(
                (int)round($value->red * 0xFF),
                (int)round($value->green * 0xFF),
                (int)round($value->blue * 0xFF),
            );
        }

        return null;
    }
}
