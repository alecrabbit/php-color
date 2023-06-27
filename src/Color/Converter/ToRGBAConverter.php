<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\ICoreConverter;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\RGBA;

class ToRGBAConverter extends AConverter
{
    public function __construct(
        protected ICoreConverter $converter = new CoreConverter(),
    ) {
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
                $this->converter->hslToRgb(
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
                $this->converter->hslToRgb(
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

    /** @inheritDoc */
    protected function getTargetClass(): string
    {
        return RGBA::class;
    }
}
