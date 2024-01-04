<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\Hex\From;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AFromConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex;

class FromHSLConverter extends AFromConverter
{
    protected static function getSources(): iterable
    {
        return [];
    }

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

        return
            Hex::fromRGB($rgb->red, $rgb->green, $rgb->blue);
    }
}
