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
final class HSLAInstantiator extends AInstantiator
{

    protected function createFromDTO(DColor $value): ?IColor
    {
        if (self::isValidType($value)) {
            /** @var DHSL $value */
            return HSLA::fromHSLA(
                (int)round($value->h * 360),
                $value->s,
                $value->l,
                $value->alpha,
            );
        }

        return null;
    }

    protected static function isValidType(DColor $color): bool
    {
        return $color instanceof DHSL;
    }
}
