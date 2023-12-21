<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Exception\InvalidArgument;

final readonly class ColorRange implements IColorRange
{
    private const MAX = 1000;
    private const MIN = 2;

    public function __construct(
        private IColor|string $start,
        private IColor|string $end,
        private int $count = self::MIN,
        private int $max = self::MAX,
    ) {
        $this->assertCount($count);
    }

    private function assertCount(int $count): void
    {
        match (true) {
            $count < self::MIN => throw new InvalidArgument(
                sprintf('Number of colors must be greater than or equal %s.', self::MIN)
            ),
            $count > $this->max => throw new InvalidArgument(
                sprintf('Number of colors must be less than %s.', $this->max)
            ),
            default => null,
        };
    }

    public function getStart(): IColor|string
    {
        return $this->start;
    }

    public function getEnd(): IColor|string
    {
        return $this->end;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
