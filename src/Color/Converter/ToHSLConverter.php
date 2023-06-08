<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\RGB;

class ToHSLConverter extends AConverter
{
    public function convert(IConvertableColor $color): IConvertableColor
    {
//        if ($color instanceof IRGBColor && !$color instanceof IRGBAColor) {
//            return $color;
//        }
//
//        if ($color instanceof IRGBAColor) {
//            return
//                RGB::fromRGB(
//                    $color->getRed(),
//                    $color->getGreen(),
//                    $color->getBlue()
//                );
//        }
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
