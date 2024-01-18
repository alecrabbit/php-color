<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Store;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Store\IConverterStore;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

class ConverterStore implements IConverterStore
{
    /**
     * @var Array<class-string<IColor>, class-string<IToConverter<IColor>>>
     */
    protected static array $registered = [];

    /**
     * @param class-string<IToConverter> $converterClass
     */
    public static function register(string $converterClass): void
    {
        self::assertConverterClass($converterClass);
        foreach ($converterClass::getTargets() as $targetClass) {
            self::assertTargetClass($targetClass);
            self::$registered[$targetClass] = $converterClass;
        }
    }

    /**
     * @param class-string<IToConverter> $class
     */
    private static function assertConverterClass(string $class): void
    {
        if (!is_subclass_of($class, IToConverter::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $class,
                    IToConverter::class
                )
            );
        }
    }

    /**
     * @param class-string<IColor> $class
     */
    protected static function assertTargetClass(string $class): void
    {
        if (!(is_subclass_of($class, IColor::class) || is_subclass_of($class, DColor::class))) {
//        if (!is_subclass_of($class, IColor::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $class,
                    IColor::class
                )
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function getByTarget(string $target): IToConverter
    {
        self::assertTargetClass($target);

        return self::getConverter($target);
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @psalm-return IToConverter<T>
     */
    protected static function getConverter(string $target): IToConverter
    {
        $converterClass = self::getConverterClass($target);
        return
            new $converterClass();
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @return class-string<IToConverter<T>>
     */
    protected static function getConverterClass(string $target): string
    {
        return
            self::searchForConverter($target)
            ??
            throw new ConverterUnavailable(
                sprintf('Converter class for "%s" is not available.', $target)
            );
    }

    /**
     * @param class-string<DColor> $target
     *
     * @return null|class-string<IToConverter>
     */
    private static function searchForConverter(string $target): ?string
    {
        if (is_subclass_of($target, DColor::class)) {
            foreach (self::$registered as $converterClass) {
                /** @var IToConverter $instance */
                $instance = new $converterClass();
                if ($instance->getTargetColorModel()->dtoType() === $target) {
                    return $converterClass;
                }
            }
        }

        return self::$registered[$target] ?? null;
    }
}
