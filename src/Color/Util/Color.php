<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Registry\Registry;

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

    private static function getRegistry(): IRegistry
    {
        return new Registry();
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
}
