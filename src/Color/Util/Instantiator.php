<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Factory\IInstantiatorFactory;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\InstantiatorFactory;

// TODO (2024-01-05 15:23) [Alec Rabbit]: functionality moved to Color class, remove this class
final class Instantiator
{
    /** @var class-string<IInstantiatorFactory> */
    private static string $factoryClass = InstantiatorFactory::class;
    private static ?IInstantiatorFactory $factory = null;

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    public static function fromString(string $color): IColor
    {
        return self::getFactory()->getInstantiator($color)->fromString($color);
    }

    private static function getFactory(): IInstantiatorFactory
    {
        if (self::$factory === null) {
            self::$factory = self::createFactory();
        }
        return self::$factory;
    }

    private static function createFactory(): IInstantiatorFactory
    {
        return new self::$factoryClass();
    }

    /**
     * @param class-string<IInstantiatorFactory> $factoryClass
     */
    public static function setFactoryClass(string $factoryClass): void
    {
        self::assertFactoryClass($factoryClass);
        self::$factoryClass = $factoryClass;
    }

    private static function assertFactoryClass(string $factoryClass): void
    {
        if (!is_subclass_of($factoryClass, IInstantiatorFactory::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $factoryClass,
                    IInstantiatorFactory::class
                )
            );
        }
    }
}
