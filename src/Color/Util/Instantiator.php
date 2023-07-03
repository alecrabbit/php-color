<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Factory\InstantiatorFactory;

// TODO (2023-07-03 15:25) [Alec Rabbit]: make utility class from this
class Instantiator
{
    public static function fromString(string $color): IConvertableColor
    {
        return InstantiatorFactory::getInstantiator($color)->fromString($color);
    }
}
