<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\A\AInstantiator;

class HSLInstantiator extends AInstantiator implements IInstantiator
{
    protected const REGEXP_HSL = '/^hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)$/';
    protected const REGEXP_HSLA = '/^hsla?\((\d+),\s*(\d+)%,\s*(\d+)%(?:,\s*([\d.]+))?\)$/';

    public static function isSupported(string $color): bool
    {
        $color = self::normalize($color);
        return str_contains($color, 'hsl') && preg_match(self::REGEXP_HSLA, $color);
    }

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
