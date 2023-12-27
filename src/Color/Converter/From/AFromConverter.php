<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\From;

use AlecRabbit\Color\Contract\IConvertableColor;

abstract class AFromConverter
{
    abstract public function convert(IConvertableColor $color): IConvertableColor;

    abstract protected static function assertColor(mixed $color): void;
}
