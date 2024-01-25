<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient\Vector;

interface IVector
{
    public function get(int|float $y = null): float;
}
