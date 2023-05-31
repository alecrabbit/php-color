<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Converter\ToRGBAConverter;
use AlecRabbit\Color\Converter\ToRGBConverter;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

class ConverterFactory
{
    /**
     * @param class-string $class
     */
    public static function make(string $class): IConverter
    {
        return match ($class) {
            RGB::class => new ToRGBConverter(),
            RGBA::class => new ToRGBAConverter(),
            default => throw new ConverterUnavailable(
                sprintf('Converter for %s is not available.', $class)
            ),
        };
    }
}
