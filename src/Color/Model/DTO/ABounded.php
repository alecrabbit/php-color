<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

abstract readonly class ABounded
{
    public static function bounded(float ...$values): static
    {
        return new static(
            ...array_map(self::refineValue(...), $values),
        );
    }

    protected static function refineValue(float $value): float
    {
        return max(0.0, min(1.0, $value));
    }
}
