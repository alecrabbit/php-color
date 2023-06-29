<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Converter\ToHexConverter;
use AlecRabbit\Color\Converter\ToHSLAConverter;
use AlecRabbit\Color\Converter\ToHSLConverter;
use AlecRabbit\Color\Converter\ToRGBAConverter;
use AlecRabbit\Color\Converter\ToRGBConverter;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

class ConverterFactory implements IConverterFactory
{

    /** @inheritDoc */
    public function make(string $class): IConverter
    {
        self::assertClass($class);

        return self::getConverter($class);
    }

    /**
     * @param class-string<IConvertableColor> $class
     */
    protected static function assertClass(string $class): void
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

    /**
     * @param class-string<IConvertableColor> $class
     */
    protected static function getConverter(string $class): IConverter
    {
        $converterClass = self::getConverterClass($class);
        return new $converterClass();
    }

    /**
     * @param class-string<IConvertableColor> $class
     * @return class-string<IConverter>
     */
    protected static function getConverterClass(string $class): string
    {
        return
            self::getRegisteredConverters()[$class]
            ??
            throw new ConverterUnavailable(
                sprintf('Converter for "%s" is not available.', $class)
            );
    }

    /**
     * @return Array<class-string<IConvertableColor>, class-string<IConverter>>
     */
    protected static function getRegisteredConverters(): array
    {
        return [
            RGB::class => ToRGBConverter::class,
            RGBA::class => ToRGBAConverter::class,
            Hex::class => ToHexConverter::class,
            HSL::class => ToHSLConverter::class,
            HSLA::class => ToHSLAConverter::class,
        ];
    }
}
