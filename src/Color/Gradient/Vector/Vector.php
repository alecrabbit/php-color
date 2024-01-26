<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient\Vector;

use AlecRabbit\Color\Contract\Gradient\Vector\IVector;

final readonly class Vector implements IVector
{
    private const CALCULATION_PRECISION = 6;

    public int|float $step;

    public function __construct(
        public int|float $x,
        int|float $step,
        private int $precision = self::CALCULATION_PRECISION,
    ) {
        $this->step = $this->round($step);
    }

    private function round(float|int $value): float
    {
        return round($value, $this->precision);
    }

    public function get(int|float $y = null): float
    {
        $value = $y === null
            ? $this->x
            : $this->x + $this->step * $y;

        return $this->round($value);
    }
}
