<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\HSL;

class ToHSLConverter extends AConverter
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

        $this->unsupportedConversion($color);
    }

}
