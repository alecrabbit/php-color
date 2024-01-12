<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Registry;

use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Converter\IColorDTOConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Converter\Store\ConverterStore;
use RuntimeException;

final class Registry implements IRegistry
{
    /** @inheritDoc */
    public static function attach(string ...$classes): void
    {
        foreach ($classes as $class) {
            match (true) {
                is_subclass_of($class, IModelConverter::class) => ConverterStore::add($class),
                default => throw new InvalidArgument(sprintf('Invalid class "%s".', $class)),
            };
        }
    }

    public function getToConverter(string $target): ?IToConverter
    {
        // TODO: Implement getToConverter() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }

    public function getInstantiator(string $color): IInstantiator
    {
        // TODO: Implement getInstantiator() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }

    /** @inheritDoc */
    public function getColorConverter(IColorModel $from, IColorModel $to): IColorDTOConverter
    {
        return (new ConverterStore())->getColorConverter($from, $to);
    }
}
