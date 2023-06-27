<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColorConverter
{
    /**
     * @param class-string $class
     */
    public function to(string $class): IConverter;
}
