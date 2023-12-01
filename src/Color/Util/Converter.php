<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\ConverterFactory;

/**
 * Utility class for converter instantiation through factory.
 */
final class Converter
{
    /** @var class-string<IConverterFactory> */
    private static string $factoryClass = ConverterFactory::class;
    private static ?IConverterFactory $factory = null;

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    /**
     * @param class-string<IConvertableColor> $class
     */
    public static function to(string $class): IConverter
    {
        return self::getFactory()->make($class);
    }

    private static function getFactory(): IConverterFactory
    {
        if (self::$factory === null) {
            self::$factory = self::createFactory();
        }
        return self::$factory;
    }

    private static function createFactory(): IConverterFactory
    {
        return new self::$factoryClass();
    }

    /**
     * @param class-string<IConverterFactory> $factoryClass
     */
    public static function setFactoryClass(string $factoryClass): void
    {
        self::assertFactoryClass($factoryClass);
        self::$factoryClass = $factoryClass;
    }

    private static function assertFactoryClass(string $factoryClass): void
    {
        if (!is_subclass_of($factoryClass, IConverterFactory::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $factoryClass,
                    IConverterFactory::class
                )
            );
        }
    }
}
