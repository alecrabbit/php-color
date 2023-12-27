<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\ToRGB;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\RGBA;

class ToRGBAConverter extends AToConverter
{
    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        return RGBA::class;
    }

    public function convert(IConvertableColor $color): IConvertableColor
    {
        if ($color instanceof IRGBAColor) {
            return $color;
        }

        if ($color instanceof IRGBColor || $color instanceof IHexColor) {
            return
                RGBA::fromRGBA(
                    $color->getRed(),
                    $color->getGreen(),
                    $color->getBlue()
                );
        }

        if ($color instanceof IHSLAColor) {
            $rgb =
                (new CoreConverter())->hslToRgb(
                    $color->getHue(),
                    $color->getSaturation(),
                    $color->getLightness()
                );

            return
                RGBA::fromRGBO(
                    $rgb->red,
                    $rgb->green,
                    $rgb->blue,
                    $color->getOpacity(),
                );
        }

        if ($color instanceof IHSLColor) {
            $rgb =
                (new CoreConverter())->hslToRgb(
                    $color->getHue(),
                    $color->getSaturation(),
                    $color->getLightness()
                );
            return
                RGBA::fromRGBO(
                    $rgb->red,
                    $rgb->green,
                    $rgb->blue,
                );
        }

        $this->unsupportedConversion($color);
    }
}
