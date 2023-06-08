<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Converter\A\Override;

use AlecRabbit\Color\A\AConvertableColor;
use RuntimeException;

class AConvertableColorOverride extends AConvertableColor
{
    public function toString(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
