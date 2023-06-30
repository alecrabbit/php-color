<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Factory;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Factory\ConverterFactory;

interface IConverterFactory
{
    /**
     * @param class-string<IConvertableColor> $class
     */
    public function make(string $class): IConverter;
}
