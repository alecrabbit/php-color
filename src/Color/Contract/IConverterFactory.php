<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IConverterFactory
{
    /**
     * @param class-string $class
     */
    public function make(string $class): IConverter;
}
