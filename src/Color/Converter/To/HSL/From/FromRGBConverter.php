<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSL\From;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHasBlue;
use AlecRabbit\Color\Contract\IHasGreen;
use AlecRabbit\Color\Contract\IHasRed;
use AlecRabbit\Color\Converter\A\AFromRGBConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\HSL;

class FromRGBConverter extends AFromRGBConverter
{


    protected static function assertColor(mixed $color): void
    {
        match (true) {
            $color instanceof IHasRed && $color instanceof IHasGreen && $color instanceof IHasBlue => null,
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
        /** @var IHasRed&IHasGreen&IHasBlue $color */
        $hsl = (new CoreConverter())
            ->rgbToHsl(
                $color->getRed(),
                $color->getGreen(),
                $color->getBlue()
            );

        return HSL::fromHSL($hsl->hue, $hsl->saturation, $hsl->lightness);
    }
}
