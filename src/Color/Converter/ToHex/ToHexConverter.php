<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\ToHex;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\RGB;

class ToHexConverter extends AConverter
{
    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        return Hex::class;
    }

    public function convert(IConvertableColor $color): IConvertableColor
    {
        if ($color instanceof IHexColor) {
            return
                $color;
        }

        if ($color instanceof IRGBColor) {
            return Hex::fromInteger($color->getValue());
        }

        if ($color instanceof IHSLColor) {
            $rgb =
                (new CoreConverter())
                    ->hslToRgb($color->getHue(), $color->getSaturation(), $color->getLightness());

            return Hex::fromInteger(
                RGB::fromRGB($rgb->red, $rgb->green, $rgb->blue)->getValue()
            );
        }

        $this->unsupportedConversion($color);
    }
}
