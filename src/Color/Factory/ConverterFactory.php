<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\IConverterFactory;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Converter\ToHexConverter;
use AlecRabbit\Color\Converter\ToRGBAConverter;
use AlecRabbit\Color\Converter\ToRGBConverter;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

class ConverterFactory implements IConverterFactory
{
    /**
     * @param class-string $class
     */
    public function makeFor(string $class): IConverter
    {
        self::assertClass($class);
        return match ($class) {
            RGB::class => new ToRGBConverter(),
            RGBA::class => new ToRGBAConverter(),
            Hex::class => new ToHexConverter(),
            default => throw new ConverterUnavailable(
                sprintf('Converter for "%s" is not available.', $class)
            ),
        };
    }

    private static function assertClass(string $class): void
    {
        if (!is_subclass_of($class, IConvertableColor::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $class,
                    IConvertableColor::class
                )
            );
        }
    }
}
