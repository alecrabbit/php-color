<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\RGBA;

use function str_starts_with;

/**
 * @extends AInstantiator<IRGBAColor>
 */
class RGBAInstantiator extends AInstantiator
{
    protected const REGEXP_RGBA = '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/';

    /** @inheritDoc */
    protected function createFromString(string $value): ?IColor
    {
        $matches = [];
        if (self::canInstantiateFromString($value, $matches)) {
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

    protected static function canInstantiateFromString(string $value, array &$matches = []): bool
    {
        return str_starts_with($value, 'rgba(') && preg_match(self::REGEXP_RGBA, $value, $matches);
    }

    protected function createFromDTO(DColor $value): ?IColor
    {
        if (self::canInstantiateFromDTO($value)) {
            /** @var DRGB $value */
            return RGBA::fromRGBA(
                (int)round($value->red * 0xFF),
                (int)round($value->green * 0xFF),
                (int)round($value->blue * 0xFF),
                (int)round($value->alpha * 0xFF),
            );
        }

        return null;
    }

    protected static function canInstantiateFromDTO(DColor $color): bool
    {
        return $color instanceof DRGB;
    }
}
