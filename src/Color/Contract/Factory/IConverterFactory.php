<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Factory;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IConvertableColor;

interface IConverterFactory
{
    /**
     * @param class-string<IConvertableColor> $class
     */
    public function make(string $class): IToConverter;
}
