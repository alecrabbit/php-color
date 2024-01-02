<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGBA\From;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHasOpacity;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AFromConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\RGBA;

class FromHSLConverter extends AFromConverter
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

    protected static function createColor(IConvertableColor $color): IConvertableColor
    {
        /** @var IHSLColor $color */
        $rgb = (new CoreConverter())->hslToRgb(
            $color->getHue(),
            $color->getSaturation(),
            $color->getLightness()
        );

        $opacity = $color instanceof IHasOpacity ? $color->getOpacity() : 1.0;

        return
            RGBA::fromRGBO($rgb->red, $rgb->green, $rgb->blue, $opacity);
    }
}
