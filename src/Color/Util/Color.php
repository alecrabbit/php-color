<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Store\IConverterStore;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Store\ConverterStore;
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
    private static string $instantiatorStoreClass = InstantiatorStore::class;
    private static ?IInstantiatorStore $instantiatorStore = null;

    /** @var class-string<IConverterStore> */
    private static string $converterStoreClass = ConverterStore::class;
    private static ?IConverterStore $converterStore = null;

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    public static function fromString(string $color): IColor
    {
        return self::getInstantiatorStore()->getByString($color)->fromString($color);
    }

    private static function getInstantiatorStore(): IInstantiatorStore
    {
        if (self::$instantiatorStore === null) {
            self::$instantiatorStore = self::createInstantiatorStore();
        }
        return self::$instantiatorStore;
    }

    private static function createInstantiatorStore(): IInstantiatorStore
    {
        return new self::$instantiatorStoreClass();
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @psalm-return T
     */
    public static function from(DColor $dto, string $target): IColor
    {
        /** @var T $color */
        $color = self::getInstantiatorStore()
            ->getByTarget($target)
            ->fromDTO($dto)
        ;

        return $color;
    }
    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return IToConverter<T>
     */
    public static function to(string $class): IToConverter
    {
        return self::getConverterStore()->getByTarget($class);
    }

    /**
     * @param class-string<IInstantiatorStore> $instantiatorStoreClass
     */
    public static function setInstantiatorStoreClass(string $instantiatorStoreClass): void
    {
        self::assertStoreClass($instantiatorStoreClass);
        self::$instantiatorStoreClass = $instantiatorStoreClass;
    }

    private static function assertStoreClass(string $instantiatorStoreClass): void
    {
        if (!is_subclass_of($instantiatorStoreClass, IInstantiatorStore::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $instantiatorStoreClass,
                    IInstantiatorStore::class
                )
            );
        }
    }

    private static function getConverterStore(): IConverterStore
    {
        if (self::$converterStore === null) {
            self::$converterStore = self::createConverterStore();
        }
        return self::$converterStore;
    }

    private static function createConverterStore(): IConverterStore
    {
        return new self::$converterStoreClass();
    }
}
