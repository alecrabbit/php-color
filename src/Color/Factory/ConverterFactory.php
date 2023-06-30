<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;

class ConverterFactory implements IConverterFactory
{
    /** @var Array<class-string<IConvertableColor>, class-string<IConverter>> */
    protected static array $registeredConverters = [];

    /**
     * @param class-string<IConvertableColor> $targetClass
     * @param class-string<IConverter> $converterClass
     */
    public static function registerConverter(string $targetClass, string $converterClass): void
    {
        self::assertTargetClass($targetClass);
        self::assertConverterClass($converterClass);
        self::$registeredConverters[$targetClass] = $converterClass;
    }

    /**
     * @param class-string<IConvertableColor> $class
     */
    protected static function assertTargetClass(string $class): void
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
     * @param class-string<IConverter> $class
     */
    private static function assertConverterClass(string $class): void
    {
        if (!is_subclass_of($class, IConverter::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $class,
                    IConverter::class
                )
            );
        }
    }

    /** @inheritDoc */
    public function make(string $class): IConverter
    {
        self::assertTargetClass($class);

        return self::createConverter($class);
    }

    /**
     * @param class-string<IConvertableColor> $class
     */
    protected static function createConverter(string $class): IConverter
    {
        $converterClass = self::getConverterClass($class);
        return
            new $converterClass();
    }

    /**
     * @param class-string<IConvertableColor> $class
     * @return class-string<IConverter>
     */
    protected static function getConverterClass(string $class): string
    {
        return
            self::$registeredConverters[$class]
            ??
            throw new ConverterUnavailable(
                sprintf('Converter class for "%s" is not available.', $class)
            );
    }
}
