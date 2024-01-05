<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\Wrapper\IWrapper;
use Traversable;

interface IRegistry
{
    /**
     * @param class-string<IToConverter> $toConverter
     * @param Traversable<class-string<IColor>, class-string<IFromConverter>> $fromConverters
     * @deprecated
     *
     */
    public static function register(string $toConverter, Traversable $fromConverters): void;

    /**
     * @param IWrapper ...$wrappers
     */
    public static function attach(IWrapper ...$wrappers): void;

    /**
     * @param class-string<IToConverter> $to
     * @param class-string<IColor> $source
     */
    public function getFromConverter(string $to, string $source): ?IFromConverter;

    /**
     * @param class-string<IColor> $target
     */
    public function getToConverter(string $target): ?IToConverter;

    public function getInstantiator(string $color): IInstantiator;
}
