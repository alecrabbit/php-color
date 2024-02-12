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
final class RGBAInstantiator extends AInstantiator
{
    protected function createFromDTO(DColor $value): ?IColor
    {
        if (self::canInstantiateFromDTO($value)) {
            /** @var DRGB $value */
            return RGBA::fromRGBA(
                (int)round($value->r * 0xFF),
                (int)round($value->g * 0xFF),
                (int)round($value->b * 0xFF),
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
