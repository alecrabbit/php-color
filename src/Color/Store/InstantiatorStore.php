<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Store;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Exception\InvalidArgument;

class InstantiatorStore implements IInstantiatorStore
{
    /** @var Array<class-string<IInstantiator>> */
    protected static array $registered = [];

    /**
     * @param class-string<IColor> $target
     * @param class-string<IInstantiator> $class
     */
    public static function registerOld(string $target, string $class): void
    {
        self::assertTargetClass($target);
        self::assertClass($class);

        self::$registered[$target] = $class;
    }

    protected static function assertTargetClass(string $class): void
    {
        if (!is_subclass_of($class, IColor::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Target class "%s" is not a "%s" subclass.',
                    $class,
                    IColor::class
                )
            );
        }
    }

    protected static function assertClass(string $class): void
    {
        if (!is_subclass_of($class, IInstantiator::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Instantiator class "%s" must implement "%s" interface.',
                    $class,
                    IInstantiator::class,
                )
            );
        }
    }

    public function getByString(string $value): IInstantiator
    {
        /** @var class-string<IInstantiator> $class */
        foreach (self::$registered as $class) {
            if ($class::isSupported($value)) {
                return new $class();
            }
        }
        throw new InvalidArgument(
            sprintf(
                'Instantiator for color "%s" is not registered.',
                $value,
            )
        );
    }

    public function getByTarget(string $target): IInstantiator
    {
        $class =
            self::$registered[$target]
            ??
            throw new InvalidArgument(
                sprintf(
                    'Instantiator for target "%s" is not registered.',
                    $target,
                )
            );

        return new $class();
    }
}
