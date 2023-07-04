<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Util\Override;

use AlecRabbit\Color\Contract\Factory\IInstantiatorFactory;
use AlecRabbit\Color\Contract\IInstantiator;

final class InstantiatorFactoryOverride implements IInstantiatorFactory
{

    public function getInstantiator(string $color): IInstantiator
    {
        // TODO: Implement getInstantiator() method.
        throw new \RuntimeException('Not implemented.');
    }

    public static function registerInstantiator(string $class): void
    {
        // TODO: Implement registerInstantiator() method.
        throw new \RuntimeException('Not implemented.');
    }
}
