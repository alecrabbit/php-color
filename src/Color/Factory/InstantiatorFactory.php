<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\Factory\IInstantiatorFactory;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Instantiator;

class InstantiatorFactory implements IInstantiatorFactory
{
    /** @var Array<class-string<IInstantiator>> */
    protected static array $registeredInstantiators = [];
    /** @var class-string<IInstantiator> */
    protected static string $class = Instantiator::class;
    protected static ?IInstantiator $instance = null;

    /** @inheritDoc */
    public static function setClass(string $class): void
    {
        self::assertClass($class);
        self::$class = $class;
    }

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
                'Color "%s" is not supported.',
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
