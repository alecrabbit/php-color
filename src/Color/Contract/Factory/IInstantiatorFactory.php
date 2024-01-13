<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Factory;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;

interface IInstantiatorFactory
{
    /**
     * @param class-string<IInstantiator> $class
     */
    public static function register(string $class): void;

    public function getByString(string $value): IInstantiator;

    /**
     * @param class-string<IColor> $target
     */
    public function getByTarget(string $target): IInstantiator;
}
