<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Vector;

use AlecRabbit\Color\Contract\Vector\IVector;

use function abs;

final readonly class Vector implements IVector
{
    public function __construct(
        public int|float $x,
        public int|float $step,
    ) {
    }

    public static function create(
        int|float $start,
        int|float $end,
        int $count = null,
    ): IVector {
        return new self(
            $start,
            self::calculateStep($start, $end, $count),
        );
    }

    private static function calculateStep(float|int $start, float|int $end, ?int $count): int|float
    {
        return ($count === null || $count === 0) ? 0 : ($end - $start) / abs($count);
    }

    public function get(int|float $y = null): int|float
    {
        return $y === null
            ? $this->x
            : $this->x + $this->step * $y;
    }
}
