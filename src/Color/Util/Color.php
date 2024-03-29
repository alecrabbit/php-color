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
final class Color implements IColorUtil
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    public static function tryFrom(mixed $value): ?IColor
    {
        return match (true) {
            $value instanceof IColor => $value,
            default => self::tryFromValue($value),
        };
    }

    private static function tryFromValue(mixed $value): ?IColor
    {
        return self::getRegistry()->findInstantiator($value)?->tryFrom($value);
    }

    private static function getRegistry(): IRegistry
    {
        return new Registry();
    }

    public static function from(mixed $value): IColor
    {
        return match (true) {
            $value instanceof IColor => $value,
            default => self::fromValue($value),
        };
    }

    private static function fromValue(mixed $value): IColor
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
}
