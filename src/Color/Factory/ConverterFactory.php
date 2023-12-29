<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;

class ConverterFactory implements IConverterFactory
{
    /** @var Array<class-string<IConvertableColor>, class-string<IToConverter>> */
    protected static array $registered = [];

    /**
     * @param class-string<IConvertableColor> $targetClass
     * @param class-string<IToConverter> $converterClass
     */
    public static function register(string $targetClass, string $converterClass): void
    {
        self::assertTargetClass($targetClass);
        self::assertConverterClass($converterClass);
        self::$registered[$targetClass] = $converterClass;
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
     * @param class-string<IConvertableColor> $class
     */
    protected static function createConverter(string $class): IToConverter
    {
        $converterClass = self::getConverterClass($class);
        return
            new $converterClass();
    }

    /**
     * @param class-string<IConvertableColor> $class
     * @return class-string<IToConverter>
     */
    protected static function getConverterClass(string $class): string
    {
        return
            self::$registered[$class]
            ??
            throw new ConverterUnavailable(
                sprintf('Converter class for "%s" is not available.', $class)
            );
    }
}
