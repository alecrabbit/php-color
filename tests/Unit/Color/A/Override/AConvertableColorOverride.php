<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\A\Override;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IColorConverter;

class AConvertableColorOverride extends AConvertableColor
{
    public function getConverterProperty(): ?IColorConverter
    {
        return self::getConverter();
    }

    public function toString(): string
    {
        throw new \RuntimeException('INTENTIONALLY Not implemented.');
    }
}
