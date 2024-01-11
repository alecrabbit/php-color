<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\ConverterFactory;

/**
 * Utility class for converter instantiation through factory.
 *
 * @template-covariant TV of IColor
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
     * @template T of TV
     *
     * @param class-string<T> $class
     *
     * @psalm-return IToConverter<T>
     */
    public static function to(string $class): IToConverter
    {
        return self::getConverterFactory()->make($class);
    }

    private static function getConverterFactory(): IConverterFactory
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
