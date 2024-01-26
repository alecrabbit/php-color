<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient\A;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\Gradient\Vector\IVector;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Gradient\Vector\Vector;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Util\Color;
use Traversable;

use function is_a;

abstract readonly class AGradient implements IGradient
{
    protected const MAX = 1000;
    protected const MIN = 2;

    public function __construct(
        protected int $count,
        protected int $max,
    ) {
        $this->assertCount($count);
    }

    protected function assertCount(int $count): void
    {
        match (true) {
            $count < self::MIN => throw new InvalidArgument(
                sprintf('Number of colors must be greater than %s.', self::MIN)
            ),
            $count > $this->max => throw new InvalidArgument(
                sprintf('Number of colors must be less than %s.', $this->max)
            ),
            default => null,
        };
    }

    /** @inheritDoc */
    public function unwrap(): Traversable
    {
        for ($i = 0; $i < $this->count; $i++) {
            yield $this->getOne($i);
        }
    }

    /** @inheritDoc */

    public function getOne(int $index): IColor
    {
        return $this->createColor($this->refineIndex($index));
    }

    protected function createColor(int $index): IColor
    {
        return Color::from(
            $this->getColor($index),
        );
    }

    abstract protected function getColor(int $index): DColor|string;

    protected function refineIndex(int $index): int
    {
        return max(0, min($index, $this->count - 1));
    }

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @template T of DColor
     *
     * @param class-string<T> $type
     *
     * @psalm-return T
     */
    protected function dto(DColor|IColor|string $color, string $type): DColor
    {
        if (is_a($color, $type, true)) {
            return $color;
        }

        return $this->ensureColor($color)->to($type);
    }

    protected function ensureColor(DColor|IColor|string $color): IColor
    {
        return Color::from($color);
    }

    protected function createVector(float $start, float $end, int $count): IVector
    {
        $step = $this->calculateStep($start, $end, $count);

        return new Vector($start, $step);
    }

    protected function calculateStep(float $start, float $end, int $count): float
    {
        return $count === 0 ? 0.0 : ($end - $start) / abs($count);
    }
}
