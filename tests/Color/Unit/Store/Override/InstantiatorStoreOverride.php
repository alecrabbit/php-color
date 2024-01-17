<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Store\Override;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use RuntimeException;

final class InstantiatorStoreOverride implements IInstantiatorStore
{

    public static function register(string $targetClass, string $instantiatorClass): void
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public function getByValue(mixed $value): IInstantiator
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
