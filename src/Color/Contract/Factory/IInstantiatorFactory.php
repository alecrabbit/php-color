<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Factory;

use AlecRabbit\Color\Contract\IInstantiator;

interface IInstantiatorFactory
{
    /**
     * @param class-string $class
     */
    public static function setClass(string $class): void;

    public static function create(): IInstantiator;
}
