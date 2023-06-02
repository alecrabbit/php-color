<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory\Override;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IColorConverter;

class AConvertableColorOverride extends AConvertableColor
{
    public function toString(): string
    {
        throw new \RuntimeException('INTENTIONALLY Not implemented.');
    }
}
