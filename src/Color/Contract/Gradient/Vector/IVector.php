<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient\Vector;

interface IVector
{
    public static function create(int|float $start, int|float $end, int $count = null, int $precision = null): IVector;

    public function get(int|float $y = null): float;
}
