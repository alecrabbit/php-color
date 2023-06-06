<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\RGB;

class ToHexConverter extends AConverter
{
    public function convert(IConvertableColor $color): IConvertableColor
    {
        if ($color instanceof IHexColor) {
            return
                $color;
        }

        if ($color instanceof IRGBColor) {
            return Hex::fromInteger($color->getValue());
        }

        throw new UnsupportedColorConversion(
            sprintf(
                'Conversion from %s to %s is not supported by %s.',
                $color::class,
                RGB::class,
                static::class
            )
        );
    }

}
