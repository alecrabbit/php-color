<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\ToRGB;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\RGB;

class ToRGBConverter extends AConverter
{
    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        return RGB::class;
    }

    public function convert(IConvertableColor $color): IConvertableColor
    {
        if ($color instanceof IRGBColor && !$color instanceof IRGBAColor) {
            return $color;
        }

        if ($color instanceof IRGBAColor) {
            return
                RGB::fromRGB(
                    $color->getRed(),
                    $color->getGreen(),
                    $color->getBlue()
                );
        }

        if ($color instanceof IHexColor) {
            return
                RGB::fromRGB(
                    $color->getRed(),
                    $color->getGreen(),
                    $color->getBlue()
                );
        }


        $this->unsupportedConversion($color);
    }
}
