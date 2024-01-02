<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use Traversable;

interface IRegistry
{
    /**
     * @param class-string<IToConverter> $toConverter
     * @param Traversable<class-string<IConvertableColor>, class-string<IFromConverter>> $fromConverters
     */
    public static function register(string $toConverter, Traversable $fromConverters): void;
//    public static function register(Wrapper... $wrapper): void;

    /**
     * @param class-string<IToConverter> $toConverter
     * @param class-string<IConvertableColor> $color
     */
    public function getFromConverter(string $toConverter, string $color): ?IFromConverter;

    /**
     * @param class-string<IConvertableColor> $color
     */
    public function getToConverter(string $color): ?IToConverter;

    public function getInstantiator(string $color): IInstantiator;
}
