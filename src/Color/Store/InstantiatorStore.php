<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Store;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Exception\InvalidArgument;

final class InstantiatorStore implements IInstantiatorStore
{
    /** @var Array<class-string<IInstantiator>> */
    protected static array $registered = [];

    /**
     * @param class-string<IColor> $targetClass
     * @param class-string<IInstantiator> $instantiatorClass
     */
    public static function register(string $targetClass, string $instantiatorClass): void
    {
        self::assertTargetClass($targetClass);
        self::assertClass($instantiatorClass);

        self::$registered[$targetClass] = $instantiatorClass;
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

    public function getByValue(mixed $value): IInstantiator
    {
        /** @var class-string<IInstantiator> $class */
        foreach ($this->getRegistered() as $class) {
            if ($class::isSupported($value)) {
                return new $class();
            }
        }

        throw new InvalidArgument($this->createErrorMessage($value));
    }

    private function getRegistered(): array
    {
        return \array_reverse(self::$registered, true);
    }

    private function createErrorMessage(mixed $value): string
    {
        return \is_string($value)
            ? sprintf('Instantiator for color "%s" is not registered.', $value)
            : sprintf('Instantiator for value of type "%s" is not registered.', get_debug_type($value));
    }
}
