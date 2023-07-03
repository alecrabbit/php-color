<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory\Override;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IInstantiator;
use RuntimeException;

class InstantiatorOverride implements IInstantiator
{
    public static function isSupported(string $color): bool
    {
        // TODO: Implement isSupported() method.
        throw new RuntimeException('Not implemented.');
    }

    public function fromString(string $color): IConvertableColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
