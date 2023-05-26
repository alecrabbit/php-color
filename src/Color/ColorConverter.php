<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;

class ColorConverter implements IColorConverter
{

    public function toRGB(IConvertableColor $color): IConvertableColor
    {
        if ($color instanceof RGB) {
            return $color;
        }
        return $this->to(RGB::class)->convert($color);
//        return match ($color::class) {
//            RGB::class => $color,
//            RGBA::class => $this->to(RGB::class)->convert($color),
//            default => throw new UnsupportedColorConversion(__METHOD__),
//        };
    }

    private function to(string $class): IConverter
    {
        return ConverterFactory::make($class);
    }
    public function toRGBA(IConvertableColor $color): IConvertableColor
    {
        // TODO: Implement toRGBA() method.
        throw new \RuntimeException('Not implemented.');
    }
}
