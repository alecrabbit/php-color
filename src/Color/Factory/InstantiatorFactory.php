<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Factory;

use AlecRabbit\Color\Contract\Factory\IInstantiatorFactory;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Instantiator;

class InstantiatorFactory implements IInstantiatorFactory
{
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

    public static function getInstantiator(): IInstantiator
    {
        if (self::$instance === null) {
            self::$instance = new self::$class();
        }
        return self::$instance;
    }
}
