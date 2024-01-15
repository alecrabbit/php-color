<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Store\InstantiatorStore;

/**
 * // TODO (2024-01-05 15:24) [Alec Rabbit]: move tests InstantiatorTest to test this class
 * Utility class for convenient color instantiation.
 *
 * @codeCoverageIgnore
 */
final class Color
{
    /** @var class-string<IInstantiatorStore> */
    private static string $factoryClass = InstantiatorStore::class;
    private static ?IInstantiatorStore $factory = null;

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    public static function fromString(string $color): IColor
    {
        return self::getInstantiatorFactory()->getByString($color)->fromString($color);
    }

    private static function getInstantiatorFactory(): IInstantiatorStore
    {
        if (self::$factory === null) {
            self::$factory = self::createFactory();
        }
        return self::$factory;
    }

    private static function createFactory(): IInstantiatorStore
    {
        return new self::$factoryClass();
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @psalm-return T
     */
    public static function fromDTO(DColor $dto, string $target): IColor
    {
        /** @var T $color */
        $color = self::getInstantiatorFactory()
            ->getByTarget($target)
            ->fromDTO($dto)
        ;

        return $color;
    }

    /**
     * @param class-string<IInstantiatorStore> $factoryClass
     */
    public static function setFactoryClass(string $factoryClass): void
    {
        self::assertFactoryClass($factoryClass);
        self::$factoryClass = $factoryClass;
    }

    private static function assertFactoryClass(string $factoryClass): void
    {
        if (!is_subclass_of($factoryClass, IInstantiatorStore::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $factoryClass,
                    IInstantiatorStore::class
                )
            );
        }
    }
}
