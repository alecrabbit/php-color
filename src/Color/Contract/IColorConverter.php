<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Converter\ColorConverter;

interface IColorConverter
{
    /**
     * @param class-string $class
     */
    public function to(string $class): IConverter;
}
