<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Factory;

use AlecRabbit\Color\Contract\IInstantiator;

interface IInstantiatorFactory
{
    public function getInstantiator(string $color): IInstantiator;

    /**
     * @param class-string<IInstantiator> $class
     */
    public static function registerInstantiator(string $class): void;
}
