<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

class RGBInstantiator extends AInstantiator implements IInstantiator
{
    protected const REGEXP_RGB = '/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/';
    protected const REGEXP_RGBA = '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/';

    public static function isSupported(string $color): bool
    {
        $color = self::normalize($color);
        return str_contains($color, 'rgb') && preg_match(self::REGEXP_RGBA, $color);
    }

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
        // @codeCoverageIgnoreStart
        throw new UnrecognizedColorString(
            sprintf(
                'Unrecognized color string: "%s".',
                $color
            )
        );
        // @codeCoverageIgnoreEnd
    }
}
