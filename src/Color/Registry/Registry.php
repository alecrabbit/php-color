<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Registry;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Contract\Parser\IParser;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Converter\IConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Store\ConverterStore as ModelConverterStore;
use AlecRabbit\Color\Store\ConverterStore;
use AlecRabbit\Color\Store\InstantiatorStore;
use AlecRabbit\Color\Store\ParserStore;

final class Registry implements IRegistry
{
    /** @inheritDoc */
    public static function attach(string ...$classes): void
    {
        foreach ($classes as $class) {
            match (true) {
                is_subclass_of($class, IModelConverter::class) => self::attachModelConverter($class),
                is_subclass_of($class, IToConverter::class) => self::attachToConverter($class),
                is_subclass_of($class, IInstantiator::class) => self::attachInstantiator($class),
                default => throw new InvalidArgument(sprintf('Invalid class "%s".', $class)),
            };
        }
    }

    /** @param class-string<IModelConverter> $class */
    private static function attachModelConverter(string $class): void
    {
        ModelConverterStore::add($class);
    }

    /** @param class-string<IToConverter> $class */
    private static function attachToConverter(string $class): void
    {
        ConverterStore::register($class);
    }

    private static function attachInstantiator(string $class): void
    {
        InstantiatorStore::register($class);
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @psalm-return IToConverter<T>
     *
     * @throws ConverterUnavailable
     */
    public function getToConverter(string $target): IToConverter
    {
        return (new ConverterStore())->getByTarget($target);
    }

    public function getInstantiator(mixed $value): IInstantiator
    {
        return (new InstantiatorStore())->getByValue($value);
    }

    /** @inheritDoc */
    public function getModelConverter(
        IColorModel $from,
        IColorModel $to
    ): IConverter {
        return (new ModelConverterStore())->getConverter($from, $to);
    }

    public function findInstantiator(mixed $value): ?IInstantiator
    {
        return (new InstantiatorStore())->findByValue($value);
    }

    public function findParser(mixed $value): ?IParser
    {
        return (new ParserStore())->findByValue($value);
    }
}
