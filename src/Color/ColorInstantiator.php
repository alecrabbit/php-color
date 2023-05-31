<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColorInstantiator;
use AlecRabbit\Color\Contract\IConvertableColor;
use RuntimeException;

class ColorInstantiator implements IColorInstantiator
{
    public function fromString(string $color): IConvertableColor
    {
        if (preg_match(self::REGEXP_RGB, $color, $matches)) {
            return
                RGBA::fromRGBO(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                );
        }
        if (preg_match(self::REGEXP_RGBA, $color, $matches)) {
            return
                RGBA::fromRGBO(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                    isset($matches[4]) ? (float)$matches[4] : 1.0,
                );
        }
        throw new RuntimeException('Not implemented.');
    }
}
