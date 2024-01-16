<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\Store\IConverterStore;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Store\ConverterStore;
use AlecRabbit\Color\Store\InstantiatorStore;

/**
 * // TODO (2024-01-05 15:24) [Alec Rabbit]: move relevant tests from InstantiatorTest and ConverterTest to ColorTest
 * Utility class for convenient color instantiation.
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

    /**
     * @template T of IColor
     *
     * @param null|class-string<T> $target
     *
     * @psalm-return ($target is null ? IColor : T)
     */
    public static function from(IColor|DColor|string $value, ?string $target = null): IColor
    {
        return match (true) {
            $value instanceof IColor => $target === null
                ? $value
                : $value->to($target),
            $value instanceof DColor => $target === null
                ? self::fromDTO($value, IHexColor::class)
                : self::fromDTO($value, $target),
            default => $target === null
                ? self::fromString($value)
                : self::fromString($value)->to($target),
        };
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
        $color = self::getInstantiatorStore()
            ->getByTarget($target)
            ->from($dto)
        ;

        return $color;
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

    public static function fromString(string $color): IColor
    {
        return self::getInstantiatorStore()->getByString($color)->from($color);
    }

    /**
     * @param class-string<IInstantiatorStore> $instantiatorStoreClass
     */
    public static function setInstantiatorStoreClass(string $instantiatorStoreClass): void
    {
        self::assertInstantiatorStoreClass($instantiatorStoreClass);
        self::$instantiatorStoreClass = $instantiatorStoreClass;
    }

    private static function assertInstantiatorStoreClass(string $instantiatorStoreClass): void
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

    /**
     * @param class-string<IConverterStore> $converterStoreClass
     */
    public static function setConverterStoreClass(string $converterStoreClass): void
    {
        self::assertConverterStoreClass($converterStoreClass);
        self::$converterStoreClass = $converterStoreClass;
    }

    private static function assertConverterStoreClass(string $converterStoreClass): void
    {
        if (!is_subclass_of($converterStoreClass, IConverterStore::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $converterStoreClass,
                    IConverterStore::class
                )
            );
        }
    }
}
