<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Store;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IInstantiatorStore
{
    /**
     * @param class-string<IColor> $targetClass
     * @param class-string<IInstantiator> $instantiatorClass
     */
    public static function register(string $targetClass, string $instantiatorClass): void;

    public function getByValue(mixed $value): IInstantiator;
}
