<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Converter\IDColorConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Exception\UnsupportedModelConversion;

interface IRegistry
{
    /**
     * @param class-string<IModelConverter|IToConverter> ...$classes
     */
    public static function attach(string ...$classes): void;

    /**
     * @throws UnsupportedModelConversion
     */
    public function getModelConverter(IColorModel $from, IColorModel $to): IDColorConverter;

    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @psalm-return IToConverter<T>
     */
    public function getToConverter(string $target): IToConverter;

    /**
     * @throws InvalidArgument
     */
    public function getInstantiator(mixed $value): IInstantiator;

    public function findInstantiator(mixed $value): ?IInstantiator;
}
