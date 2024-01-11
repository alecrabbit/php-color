<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;

class ConverterFactory implements IConverterFactory
{
    /**
     * @var Array<class-string<IColor>, class-string<IToConverter<IColor>>>
     */
    protected static array $registered = [];

    /**
     * @param class-string<IColor> $targetClass
     * @param class-string<IToConverter> $converterClass
     */
    public static function register(string $targetClass, string $converterClass): void
    {
        self::assertTargetClass($targetClass);
        self::assertConverterClass($converterClass);
        self::$registered[$targetClass] = $converterClass;
    }

    /**
     * @param class-string<IColor> $class
     */
    protected static function assertTargetClass(string $class): void
    {
        if (!is_subclass_of($class, IColor::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $class,
                    IColor::class
                )
            );
        }
    }

    /**
     * @param class-string<IToConverter> $class
     */
    private static function assertConverterClass(string $class): void
    {
        if (!is_subclass_of($class, IToConverter::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $class,
                    IToConverter::class
                )
            );
        }
    }

    /** @inheritDoc */
    public function make(string $class): IToConverter
    {
        self::assertTargetClass($class);

        return self::createConverter($class);
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return IToConverter<T>
     */
    protected static function createConverter(string $class): IToConverter
    {
        $converterClass = self::getConverterClass($class);
        return
            new $converterClass();
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @return class-string<IToConverter<T>>
     */
    protected static function getConverterClass(string $class): string
    {
        /** @var null|class-string<IToConverter<T>> $var */
        $var = self::$registered[$class] ?? null;

        return
            $var
            ??
            throw new ConverterUnavailable(
                sprintf('Converter class for "%s" is not available.', $class)
            );
    }
}
