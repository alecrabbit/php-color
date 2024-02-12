<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient\Vector;

interface IGradientVector
{
    public function get(int|float $y): float;
}
