<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Factory\InstantiatorFactory;

final class Instantiator
{
    public static function fromString(string $color): IConvertableColor
    {
        return InstantiatorFactory::getInstantiator($color)->fromString($color);
    }
}
