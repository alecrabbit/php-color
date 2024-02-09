<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Service;

use AlecRabbit\Color\Contract\Service\IFloatExtractor;

final readonly class FloatExtractor implements IFloatExtractor
{
    public function value(string $v, float $div = 1.0): float
    {
        if (str_ends_with($v, '%')) {
            return (float)$v / 100;
        }

        return (float)$v / $div;
    }
}
