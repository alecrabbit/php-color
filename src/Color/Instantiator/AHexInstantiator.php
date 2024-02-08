<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\AHex;
use AlecRabbit\Color\Contract\IAHexColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;

/**
 * @extends AInstantiator<IAHexColor>
 */
class AHexInstantiator extends AInstantiator
{
    protected const REGEXP_HEX = '/^#?(?:([a-f\d]{2}){4}|([a-f\d]){4})$/i';

    /** @inheritDoc */
    protected function createFromString(string $value): ?IColor
    {
        if (self::canInstantiateFromString($value)) {
            return AHex::fromInteger(self::extractInteger($value));
        }

        return null;
    }

    protected static function canInstantiateFromString(string $value, array &$matches = []): bool
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
            return AHex::fromRGBA(
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
