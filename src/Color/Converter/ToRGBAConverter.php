<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
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

        if ($color instanceof IRGBColor) {
            return
                RGBA::fromRGBA(
                    $color->getRed(),
                    $color->getGreen(),
                    $color->getBlue()
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
