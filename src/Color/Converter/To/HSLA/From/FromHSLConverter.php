<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSLA\From;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHasHue;
use AlecRabbit\Color\Contract\IHasLightness;
use AlecRabbit\Color\Contract\IHasOpacity;
use AlecRabbit\Color\Contract\IHasSaturation;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AFromConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\HSLA;

class FromHSLConverter extends AFromConverter
{
    protected static function getSources(): iterable
    {
        return [];
    }

    protected static function assertColor
    (
        mixed $color
    ): void {
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
        $opacity = $color instanceof IHasOpacity ? $color->getOpacity() : 1.0;

        /** @var IHasHue&IHasSaturation&IHasLightness $color */
        return
            HSLA::fromHSLA($color->getHue(), $color->getSaturation(), $color->getLightness(), $opacity);
    }
}