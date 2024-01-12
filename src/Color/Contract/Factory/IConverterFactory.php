<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Factory;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;

interface IConverterFactory
{
    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return IToConverter<T>
     */
    public function make(string $class): IToConverter;
}
