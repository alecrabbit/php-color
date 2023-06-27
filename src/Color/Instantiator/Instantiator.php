<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

class Instantiator implements IInstantiator
{
    protected const REGEXP_HEX = '/^#?(?:([a-f\d]{2}){3}|([a-f\d]){3})$/i';
    protected const REGEXP_HSL = '/^hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)$/';
    protected const REGEXP_HSLA = '/^hsla?\((\d+),\s*(\d+)%,\s*(\d+)%(?:,\s*([\d.]+))?\)$/';
    protected const REGEXP_RGB = '/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/';
    protected const REGEXP_RGBA = '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/';

    public function fromString(string $color): IConvertableColor
    {
        if (preg_match(self::REGEXP_HSL, $color, $matches)) {
            return
                HSL::fromHSL(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                );
        }
        if (preg_match(self::REGEXP_HSLA, $color, $matches)) {
            return
                HSLA::fromHSLA(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                    isset($matches[4]) ? (float)$matches[4] : 1.0,
                );
        }
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
            return self::hexFromString($color);
        }

        throw new UnrecognizedColorString(
            sprintf(
                'Unrecognized color string: "%s".',
                $color
            )
        );
    }

    protected static function hexFromString(string $color): IConvertableColor
    {
        return
            Hex::fromInteger(
                hexdec(
                    self::normalizeHexString($color)
                )
            );
    }

    protected static function normalizeHexString(string $hex): string
    {
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        return $hex;
    }
}
