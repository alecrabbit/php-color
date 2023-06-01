<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColorInstantiator;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Exception\UnrecognizedColorString;

class ColorInstantiator implements IColorInstantiator
{
    public function fromString(string $color): IConvertableColor
    {
        if (preg_match(self::REGEXP_RGB, $color, $matches)) {
            return
                RGB::fromRGB(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                );
        }
        if (preg_match(self::REGEXP_RGBA, $color, $matches)) {
            return
                RGBA::fromRGBO(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                    isset($matches[4]) ? (float)$matches[4] : 1.0,
                );
        }
        if (preg_match(self::REGEXP_HEX, $color)) {
            return self::fromHex($color);
        }
        throw new UnrecognizedColorString(
            sprintf(
                'Unrecognized color string: "%s".',
                $color
            )
        );
    }

    protected static function fromHex(string $color): IConvertableColor
    {
        return
            Hex::fromInteger(
                hexdec(
                    self::normalizeHex($color)
                )
            );
    }

    private static function normalizeHex(string $hex): string
    {
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        return $hex;
    }
}
