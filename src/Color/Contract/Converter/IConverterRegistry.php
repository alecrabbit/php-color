<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use Traversable;

interface IConverterRegistry
{
    /**
     * @param class-string<IToConverter> $toConverter
     * @param Traversable<class-string<IConvertableColor>, class-string<IFromConverter>> $fromConverters
     */
    public static function register(string $toConverter, Traversable $fromConverters): void;

    /**
     * @param class-string<IToConverter> $toConverter
     * @param class-string<IConvertableColor> $color
     */
    public function getFromConverter(string $toConverter, string $color): ?IFromConverter;
}
