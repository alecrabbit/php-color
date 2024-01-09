<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSLA\From;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHasBlue;
use AlecRabbit\Color\Contract\IHasGreen;
use AlecRabbit\Color\Contract\IHasOpacity;
use AlecRabbit\Color\Contract\IHasRed;
use AlecRabbit\Color\Converter\A\AFromRGBConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\Converter\Core\LegacyCoreConverter;

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
        $hsl = (new LegacyCoreConverter())
            ->rgbToHsl(
                $color->getRed(),
                $color->getGreen(),
                $color->getBlue()
            );

        $opacity = $color instanceof IHasOpacity ? $color->getOpacity() : 1.0;

        return HSLA::fromHSLA($hsl->hue, $hsl->saturation, $hsl->lightness, $opacity);
    }
}
