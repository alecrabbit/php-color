<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\Factory\IInstantiatorFactory;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;

class InstantiatorFactory implements IInstantiatorFactory
{
    /** @var Array<class-string<IInstantiator>> */
    protected static array $registeredInstantiators = [];

    protected static ?IInstantiator $instance = null;

    protected static function assertClass(string $class): void
    {
        if (!is_subclass_of($class, IInstantiator::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" must implement "%s" interface.',
                    $class,
                    IInstantiator::class,
                )
            );
        }
    }

    public static function getInstantiator(string $color): IInstantiator
    {
        /** @var IInstantiator $class */
        foreach (self::$registeredInstantiators as $class) {
            if ($class::isSupported($color)) {
                return new $class();
            }
        }
        throw new InvalidArgument(
            sprintf(
                'Instantiator for color "%s" is not registered.',
                $color,
            )
        );
    }

    /** @inheritDoc */
    public static function registerInstantiator(string $class): void
    {
        if (!in_array($class, self::$registeredInstantiators, true)) {
            self::assertClass($class);
            self::$registeredInstantiators[] = $class;
        }
    }
}
