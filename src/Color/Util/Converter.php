<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Store\IConverterStore;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Store\ConverterStore;

/**
 * Utility class for converter instantiation through factory.
 * @deprecated TODO (2024-01-15 14:24) [Alec Rabbit]: mv functionality to Color::class, remove this class
 */
final class Converter
{
    /** @var class-string<IConverterStore> */
    private static string $factoryClass = ConverterStore::class;
    private static ?IConverterStore $factory = null;

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     */
    public static function to(string $class): IToConverter
    {
        return self::getConverterFactory()->getByTarget($class);
    }

    private static function getConverterFactory(): IConverterStore
    {
        if (self::$factory === null) {
            self::$factory = self::createFactory();
        }
        return self::$factory;
    }

    private static function createFactory(): IConverterStore
    {
        return new self::$factoryClass();
    }

    /**
     * @param class-string<IConverterStore> $factoryClass
     */
    public static function setFactoryClass(string $factoryClass): void
    {
        self::assertFactoryClass($factoryClass);
        self::$factoryClass = $factoryClass;
    }

    private static function assertFactoryClass(string $factoryClass): void
    {
        if (!is_subclass_of($factoryClass, IConverterStore::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $factoryClass,
                    IConverterStore::class
                )
            );
        }
    }
}
