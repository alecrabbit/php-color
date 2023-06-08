<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\HSLA;

class ToHSLAConverter extends AConverter
{
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

        $this->unsupportedConversion($color);
    }

    /** @inheritDoc */
    protected function getTargetClass(): string
    {
        return HSLA::class;
    }
}
