<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Factory\ConverterFactory;

class ColorConverter implements IColorConverter
{
    public function toRGB(IConvertableColor $color): IConvertableColor
    {
        return $this->to(RGB::class)->convert($color);
    }

    /**
     * @param class-string $class
     */
    protected function to(string $class): IConverter
    {
        return ConverterFactory::make($class);
    }

    public function toRGBA(IConvertableColor $color): IConvertableColor
    {
        return $this->to(RGBA::class)->convert($color);
    }

    public function toHex(IConvertableColor $color): IConvertableColor
    {
        return $this->to(Hex::class)->convert($color);
    }
}
