<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\ToHSL;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\HSL;

class ToHSLConverter extends AToConverter
{
    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        return HSL::class;
    }

    public function convert(IConvertableColor $color): IConvertableColor
    {
        if ($color instanceof IHSLColor && !$color instanceof IHSLAColor) {
            return $color;
        }

        if ($color instanceof IHSLAColor) {
            return
                HSL::fromHSL(
                    $color->getHue(),
                    $color->getSaturation(),
                    $color->getLightness()
                );
        }

        if ($color instanceof IRGBColor) {
            $hsl =
                (new CoreConverter())->rgbToHsl(
                    $color->getRed(),
                    $color->getGreen(),
                    $color->getBlue()
                );
            return
                HSL::fromHSL(
                    $hsl->hue,
                    $hsl->saturation,
                    $hsl->lightness
                );
        }

        $this->unsupportedConversion($color);
    }

}
