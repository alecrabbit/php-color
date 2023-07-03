<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\Hex;

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

        $this->unsupportedConversion($color);
    }
}
