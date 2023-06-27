<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory\Override;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IInstantiator;

class InstantiatorOverride implements IInstantiator
{
    public function fromString(string $color): IConvertableColor
    {
        throw new \RuntimeException('INTENTIONALLY Not implemented.');
    }
}
