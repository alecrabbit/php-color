<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Registry\Registry;
use AlecRabbit\Color\Util\Contract\IColorUtility;

/**
 * Utility class for convenient color instantiation.
 */
final class Color implements IColorUtility
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    /** @inheritDoc */
    public static function from(mixed $value): IColor
    {
        $color = self::tryFrom($value);

        return $color
            ??
            throw new UnsupportedValue(
                sprintf(
                    'Failed to instantiate color from value of type "%s".',
                    get_debug_type($value),
                ),
            );
    }

    /** @inheritDoc */
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
}
