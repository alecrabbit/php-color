<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Converter\A\AConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

class ToRGBConverter extends AConverter
{
    public function convert(IConvertableColor $color): IConvertableColor
    {
        $this->assertColor($color);

        if ($color instanceof RGB && !$color instanceof RGBA) {
            return $color;
        }

        return
            RGB::fromRGB(
                $color->getRed(),
                $color->getGreen(),
                $color->getBlue()
            );
    }

    protected function assertColor(IConvertableColor $color): void
    {
        match ($color::class) {
            RGB::class, RGBA::class => null,
            default => throw new UnsupportedColorConversion(
                sprintf(
                    'Conversion from %s to %s is not supported by %s.',
                    $color::class,
                    RGB::class,
                    static::class
                )
            ),
        };
    }

}
