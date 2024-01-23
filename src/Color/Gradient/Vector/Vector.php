<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient\Vector;

use AlecRabbit\Color\Contract\Gradient\Vector\IVector;

use function abs;

final readonly class Vector implements IVector
{
    // TODO (2024-01-23 15:57) [Alec Rabbit]: add namespaced const CALCULATION_PRECISION = 6; [c16baba0-8d27-42f4-bc27-bf9d771c16f7]

    public function __construct(
        public int|float $x,
        public int|float $step,
        private int $precision,
    ) {
    }

    public static function create(
        int|float $start,
        int|float $end,
        int $count = null,
        int $precision = null,
    ): IVector {
        return new self(
            $start,
            self::calculateStep($start, $end, $count),
            $precision ?? 6, // todo [c16baba0-8d27-42f4-bc27-bf9d771c16f7]
        );
    }

    private static function calculateStep(float|int $start, float|int $end, ?int $count): int|float
    {
        return ($count === null || $count === 0) ? 0 : ($end - $start) / abs($count);
    }

    public function get(int|float $y = null): float
    {
        $value = $y === null
            ? $this->x
            : $this->x + $this->step * $y;

        return round($value, $this->precision);
    }
}
