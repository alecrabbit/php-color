<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient\Vector;

interface IVector
{
    /**
     * // TODO (2024-01-24 12:07) [Alec Rabbit]: it seems like this method does not belong here
     */
    public static function create(int|float $start, int|float $end, int $count = null, int $precision = null): IVector;

    public function get(int|float $y = null): float;
}
