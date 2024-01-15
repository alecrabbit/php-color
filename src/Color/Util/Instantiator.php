<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Store\InstantiatorStore;

// TODO (2024-01-05 15:23) [Alec Rabbit]: functionality moved to Color class, remove this class
final class Instantiator
{
    /** @var class-string<IInstantiatorStore> */
    private static string $storeClass = InstantiatorStore::class;
    private static ?IInstantiatorStore $store = null;

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    public static function fromString(string $color): IColor
    {
        return self::getStore()->getByString($color)->fromString($color);
    }

    private static function getStore(): IInstantiatorStore
    {
        if (self::$store === null) {
            self::$store = self::createStore();
        }
        return self::$store;
    }

    private static function createStore(): IInstantiatorStore
    {
        return new self::$storeClass();
    }

    /**
     * @param class-string<IInstantiatorStore> $storeClass
     */
    public static function setStoreClass(string $storeClass): void
    {
        self::assertStoreClass($storeClass);
        self::$storeClass = $storeClass;
    }

    private static function assertStoreClass(string $storeClass): void
    {
        if (!is_subclass_of($storeClass, IInstantiatorStore::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $storeClass,
                    IInstantiatorStore::class
                )
            );
        }
    }
}
