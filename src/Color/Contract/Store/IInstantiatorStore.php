<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Store;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;

interface IInstantiatorStore
{
    /**
     * @param class-string<IColor> $target
     * @param class-string<IInstantiator> $class
     */
    public static function registerOld(string $target, string $class): void;

    public function getByString(string $value): IInstantiator;

    /**
     * @param class-string<IColor> $target
     */
    public function getByTarget(string $target): IInstantiator;
}
