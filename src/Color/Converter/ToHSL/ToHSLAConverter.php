<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\ToHSL;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\HSLA;

class ToHSLAConverter extends AConverter
{
    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        return HSLA::class;
    }

    public function convert(IConvertableColor $color): IConvertableColor
    {
        if ($color instanceof IHSLAColor) {
            return $color;
        }

        if ($color instanceof IHSLColor) {
            return
                HSLA::fromHSL(
                    $color->getHue(),
                    $color->getSaturation(),
                    $color->getLightness(),
                );
        }

        if ($color instanceof IRGBAColor) {
            $hsl =
                (new CoreConverter())->rgbToHsl(
                    $color->getRed(),
                    $color->getGreen(),
                    $color->getBlue()
                );

            return
                HSLA::fromHSLA(
                    $hsl->hue,
                    $hsl->saturation,
                    $hsl->lightness,
                    $color->getOpacity(),
                );
        }


        if ($color instanceof IRGBColor || $color instanceof IHexColor)    {
            $hsl =
                (new CoreConverter())->rgbToHsl(
                    $color->getRed(),
                    $color->getGreen(),
                    $color->getBlue()
                );

            return
                HSLA::fromHSL(
                    $hsl->hue,
                    $hsl->saturation,
                    $hsl->lightness
                );
        }


        $this->unsupportedConversion($color);
    }
}
