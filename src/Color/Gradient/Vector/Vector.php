<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient\Vector;

use AlecRabbit\Color\Contract\Gradient\Vector\IVector;

use function abs;

final readonly class Vector implements IVector
{
    private const CALCULATION_PRECISION = 6;

    public function __construct(
        public int|float $x,
        public int|float $step,
        private int $precision = self::CALCULATION_PRECISION,
    ) {
    }

    public function get(int|float $y = null): float
    {
        $value = $y === null
            ? $this->x
            : $this->x + $this->step * $y;

        return round($value, $this->precision);
    }
}
