<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\Factory\IInstantiatorFactory;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;

class InstantiatorFactory implements IInstantiatorFactory
{
    /** @var Array<class-string<IInstantiator>> */
    protected static array $registered = [];

    /**
     * @param class-string<IInstantiator> $class
     */
    public static function register(string $class): void
    {
        self::assertClass($class);
        if (!in_array($class, self::$registered, true)) {
            self::$registered[$class::getTargetClass()] = $class;
        }
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
        // TODO: Implement getByTarget() method.
        throw new \RuntimeException('Not implemented.');
    }
}
