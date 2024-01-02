<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSL\From;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHasHue;
use AlecRabbit\Color\Contract\IHasLightness;
use AlecRabbit\Color\Contract\IHasOpacity;
use AlecRabbit\Color\Contract\IHasSaturation;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AFromConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
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
        /** @var IHasHue&IHasSaturation&IHasLightness $color */
        return
            HSL::fromHSL($color->getHue(), $color->getSaturation(), $color->getLightness());
    }
}
