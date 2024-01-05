<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGB\From;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AFromHSLConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\RGB;

class FromHSLConverter extends AFromHSLConverter
{

    protected static function assertColor(mixed $color): void
    {
        match (true) {
            $color instanceof IHSLColor => null,
            default => throw new InvalidArgument(
                sprintf(
                    'Unsupported color type "%s".',
                    $color::class
                )
            ),
        };
    }

    protected static function createColor(IColor $color): IColor
    {
        /** @var IHSLColor $color */
        $rgb = (new CoreConverter())->hslToRgb(
            $color->getHue(),
            $color->getSaturation(),
            $color->getLightness()
        );

        return
            RGB::fromRGB($rgb->red, $rgb->green, $rgb->blue);
    }
}
