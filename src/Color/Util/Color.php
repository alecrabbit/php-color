<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Factory\IInstantiatorFactory;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\InstantiatorFactory;
use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;

/**
 * // TODO (2024-01-05 15:24) [Alec Rabbit]: move tests InstantiatorTest to test this class
 * Utility class for convenient color instantiation.
 *
 * @codeCoverageIgnore
 */
final class Color
{
    /** @var class-string<IInstantiatorFactory> */
    private static string $factoryClass = InstantiatorFactory::class;
    private static ?IInstantiatorFactory $factory = null;

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    public static function fromString(string $color): IColor
    {
        return self::getInstantiatorFactory()->getByString($color)->fromString($color);
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @psalm-return T
     */
    public static function fromDTO(IColorDTO $dto, string $target): IColor
    {
        /** @var T $color */
        $color = self::getInstantiatorFactory()
            ->getByTarget($target)
            ->fromDTO($dto);

        return $color;
    }

    private static function getInstantiatorFactory(): IInstantiatorFactory
    {
        if (self::$factory === null) {
            self::$factory = self::createFactory();
        }
        return self::$factory;
    }

    private static function createFactory(): IInstantiatorFactory
    {
        return new self::$factoryClass();
    }

    /**
     * @param class-string<IInstantiatorFactory> $factoryClass
     */
    public static function setFactoryClass(string $factoryClass): void
    {
        self::assertFactoryClass($factoryClass);
        self::$factoryClass = $factoryClass;
    }

    private static function assertFactoryClass(string $factoryClass): void
    {
        if (!is_subclass_of($factoryClass, IInstantiatorFactory::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not a "%s" subclass.',
                    $factoryClass,
                    IInstantiatorFactory::class
                )
            );
        }
    }
}
