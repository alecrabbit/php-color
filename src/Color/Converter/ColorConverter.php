<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Contract\IConverterFactory;
use AlecRabbit\Color\Factory\ConverterFactory;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

class ColorConverter implements IColorConverter
{
    public function __construct(
        protected IConverterFactory $converterFactory = new ConverterFactory()
    ) {
    }

    /** @deprecated */
    public function toRGB(IConvertableColor $color): IConvertableColor
    {
        return $this->to(RGB::class)->convert($color);
    }

    /**
     * @param class-string $class
     */
    public function to(string $class): IConverter
    {
        return $this->converterFactory->make($class);
    }

    /** @deprecated */
    public function toRGBA(IConvertableColor $color): IConvertableColor
    {
        return $this->to(RGBA::class)->convert($color);
    }

    /** @deprecated */
    public function toHex(IConvertableColor $color): IConvertableColor
    {
        return $this->to(Hex::class)->convert($color);
    }

    /** @deprecated */
    public function toHSL(IConvertableColor $color): IConvertableColor
    {
        return $this->to(HSL::class)->convert($color);
    }

    /** @deprecated */
    public function toHSLA(IConvertableColor $color): IConvertableColor
    {
        return $this->to(HSLA::class)->convert($color);
    }
}
