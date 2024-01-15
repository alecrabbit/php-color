<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Util\Override;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use RuntimeException;

final class InstantiatorStoreOverride implements IInstantiatorStore
{

    public static function register(string $class): void
    {
        // TODO: Implement registerInstantiator() method.
        throw new RuntimeException('Not implemented.');
    }

    public function getByString(string $value): IInstantiator
    {
        // TODO: Implement getInstantiator() method.
        throw new RuntimeException('Not implemented.');
    }

    public function getByTarget(string $target): IInstantiator
    {
        // TODO: Implement getByTarget() method.
        throw new RuntimeException('Not implemented.');
    }
}
