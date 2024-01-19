<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHex8Color;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;

/**
 * @extends AInstantiator<IHex8Color>
 */
class Hex8Instantiator extends AInstantiator
{
    protected const REGEXP_HEX = '/^#?(?:([a-f\d]{2}){4}|([a-f\d]){4})$/i';

    /** @inheritDoc */
    protected function createFromString(string $value): ?IColor
    {
        if (self::canInstantiateFromString($value)) {
            return Hex8::fromInteger8(self::extractInteger($value));
        }

        return null;
    }

    protected static function canInstantiateFromString(string $value, &$matches = null): bool
    {
        return (bool)preg_match(self::REGEXP_HEX, $value);
    }

    protected static function extractInteger(string $color): int
    {
        return (int)hexdec(self::normalizeHexString($color));
    }

    protected static function normalizeHexString(string $hex): string
    {
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) === 4) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2] . $hex[3] . $hex[3];
        }

        return $hex;
    }

    protected function createFromDTO(DColor $value): ?IColor
    {
        if (self::canInstantiateFromDTO($value)) {
            /** @var DRGB $value */
            return Hex8::fromRGBA(
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
