<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\A\AInstantiator;

class HSLAInstantiator extends AInstantiator implements IInstantiator
{
    protected const REGEXP_HSLA = '/^hsla?\((\d+),\s*(\d+)%,\s*(\d+)%(?:,\s*([\d.]+))?\)$/';
    protected const PRECISION = 2;

    protected static function canInstantiate(string $color): bool
    {
        return str_contains($color, 'hsla(');
    }

    public function fromString(string $color): IConvertableColor
    {
        $color = self::normalize($color);
        if (self::canInstantiate($color) && preg_match(self::REGEXP_HSLA, $color, $matches)) {
            return
                HSLA::fromHSLA(
                    (int)$matches[1],
                    round(((int)$matches[2]) / 100, self::PRECISION),
                    round(((int)$matches[3]) / 100, self::PRECISION),
                    isset($matches[4])
                        ? round((float)$matches[4], self::PRECISION)
                        : 1.0,
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
