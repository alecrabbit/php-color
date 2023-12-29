<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Instantiator\A\AInstantiator;
use AlecRabbit\Color\RGB;

use function str_starts_with;

class RGBInstantiator extends AInstantiator
{
    protected const REGEXP_RGB = '/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/';

    protected static function canInstantiate(string $color): bool
    {
        return str_starts_with($color, 'rgb(');
    }

    public function fromString(string $color): IConvertableColor
    {
        $color = self::normalize($color);

        if (self::canInstantiate($color) && preg_match(self::REGEXP_RGB, $color, $matches)) {
            return
                RGB::fromRGB(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                );
        }

        throw new UnrecognizedColorString(
            sprintf(
                'Unrecognized color string: "%s".',
                $color
            )
        );
    }

    protected function instantiate(string $color): ?IConvertableColor
    {
        // TODO: Implement instantiate() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
