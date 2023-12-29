<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Factory;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;

interface IInstantiatorFactory
{
    /**
     * @param class-string<IInstantiator> $class
     */
    public static function register(string $class): void;

    public function getInstantiator(string $color): IInstantiator;
}
