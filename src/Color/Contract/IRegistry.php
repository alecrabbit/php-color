<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Model\Contract\Converter\IDColorConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;

interface IRegistry
{
    /**
     * @param class-string<IModelConverter|IToConverter> ...$classes
     */
    public static function attach(string ...$classes): void;

    /**
     * @throws UnsupportedColorConversion
     */
    public function getColorConverter(IColorModel $from, IColorModel $to): IDColorConverter;

    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @psalm-return IToConverter<T>
     */
    public function getToConverter(string $target): IToConverter;

    public function getInstantiator(mixed $value): IInstantiator;
}
