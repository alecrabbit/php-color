<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\RGBA;

class ToRGBAConverter extends AConverter
{
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
            return
                RGBA::fromRGBO(
                    0,
                    0,
                    0,
                    $color->getOpacity(),
                );
        }

        if ($color instanceof IHSLColor) {
            return
                RGBA::fromRGBO(
                    0,
                    0,
                    0,
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
