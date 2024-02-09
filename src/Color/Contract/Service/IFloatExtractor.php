<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Service;

interface IFloatExtractor
{
    public function value(string $v, float $div = 1.0): float;
}
