<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory\Override;

use AlecRabbit\Color\A\AConvertableColor;
use RuntimeException;

class AConvertableColorOverride extends AConvertableColor
{
    public function toString(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
