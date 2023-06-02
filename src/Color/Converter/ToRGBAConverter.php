<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

class ToRGBAConverter extends AConverter
{
    public function convert(IConvertableColor $color): IConvertableColor
    {
        if ($color instanceof IRGBAColor) {
            return $color;
        }

        if ($color instanceof RGB) {
            return
                RGBA::fromRGBA(
                    $color->getRed(),
                    $color->getGreen(),
                    $color->getBlue()
                );
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
