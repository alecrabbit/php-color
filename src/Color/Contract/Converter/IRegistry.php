<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;

interface IRegistry
{
    /**
     * @param class-string<IInstantiator|IModelConverter|IToConverter> ...$classes
     */
    public static function attach(string ...$classes): void;

    /**
     * @param class-string<IToConverter> $to
     * @param class-string<IColor> $source
     */
    public function getFromConverter(string $to, string $source): ?IFromConverter;

    /**
     * @throws UnsupportedColorConversion
     */
    public function getModelConverter(IColorModel $from, IColorModel $to): IModelConverter;

    /**
     * @param class-string<IColor> $target
     */
    public function getToConverter(string $target): ?IToConverter;

    public function getInstantiator(string $color): IInstantiator;
}
