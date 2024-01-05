<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Factory;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;

interface IConverterFactory
{
    /**
     * @param class-string<IColor> $class
     */
    public function make(string $class): IToConverter;
}
