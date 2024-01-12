<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\Instantiator\A\AInstantiator;

class Hex8Instantiator extends AInstantiator
{
    protected const REGEXP_HEX = '/^#?(?:([a-f\d]{2}){4}|([a-f\d]){4})$/i';


    public static function getTargetClass(): string
    {
        return Hex8::class;
    }

    public static function isSupported(string $color): bool
    {
        $color = self::normalize($color);

        return self::canInstantiate($color);
    }

    protected static function canInstantiate(string $color): bool
    {
        return self::isHexString($color);
    }

    protected static function isHexString(string $color): bool
    {
        return (bool)preg_match(self::REGEXP_HEX, $color);
    }

    protected function instantiate(string $color): ?IColor
    {
        if (self::isHexString($color)) {
            return Hex8::fromInteger8(self::extractInteger($color));
        }

        return null;
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
}
