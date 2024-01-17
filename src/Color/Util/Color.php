<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Contract\Store\IConverterStore;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Registry\Registry;
use AlecRabbit\Color\Store\ConverterStore;
use AlecRabbit\Color\Store\InstantiatorStore;

/**
 * Utility class for convenient color instantiation.
 */
final class Color
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    public static function from(mixed $value): IColor
    {
        return match (true) {
            $value instanceof IColor => $value,
            default => self::fromValue($value),
        };
    }

    protected static function fromValue(mixed $value): IColor
    {
        return self::getRegistry()->getInstantiator($value)->from($value);
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @psalm-return IToConverter<T>
     */
    public static function to(string $target): IToConverter
    {
        return self::getRegistry()->getToConverter($target);
    }

    private static function getRegistry(): IRegistry
    {
        return new Registry();
    }
}
