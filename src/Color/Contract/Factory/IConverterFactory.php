<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Factory;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IToConverter;

interface IConverterFactory
{
    /**
     * @param class-string<IConvertableColor> $class
     */
    public function make(string $class): IToConverter;
}
