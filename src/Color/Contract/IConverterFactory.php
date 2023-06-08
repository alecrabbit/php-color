<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IConverterFactory
{
    /**
     * @param class-string $class
     */
    public function makeFor(string $class): IConverter;
}
