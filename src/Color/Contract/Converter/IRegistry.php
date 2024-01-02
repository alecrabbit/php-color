<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use Traversable;

interface IRegistry
{
    /**
     * @deprecated
     *
     * @param class-string<IToConverter> $toConverter
     * @param Traversable<class-string<IConvertableColor>, class-string<IFromConverter>> $fromConverters
     */
    public static function register(string $toConverter, Traversable $fromConverters): void;

    /**
     * @param class-string<IToConverter|IFromConverter|IInstantiator> ...$class
     */
    public static function attach(string ...$class): void;

    /**
     * @param class-string<IToConverter> $to
     * @param class-string<IConvertableColor> $source
     */
    public function getFromConverter(string $to, string $source): ?IFromConverter;

    /**
     * @param class-string<IConvertableColor> $target
     */
    public function getToConverter(string $target): ?IToConverter;

    public function getInstantiator(string $color): IInstantiator;
}
