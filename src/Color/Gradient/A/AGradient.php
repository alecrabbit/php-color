<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient\A;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\Gradient\Vector\IGradientVector;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Gradient\Vector\GradientVector;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Util\Color;
use Traversable;

use function is_a;

abstract readonly class AGradient implements IGradient
{
    protected const MIN = 2;

    /** @inheritDoc */
    public function unwrap(int $count): Traversable
    {
        for ($i = 0; $i < $count; $i++) {
            yield $this->getOne($i, $count);
        }
    }

    /** @inheritDoc */

    public function getOne(int $index, int $count = 100): IColor
    {
        $this->assertCount($count);

        return $this->createColor($this->refineIndex($index, $count), $count);
    }

    protected function assertCount(int $count): void
    {
        match (true) {
            $count < self::MIN => throw new InvalidArgument(
                sprintf('Number of colors must be greater than %s.', self::MIN)
            ),
            default => null,
        };
    }

    protected function createColor(int $index, int $count): IColor
    {
        return Color::from(
            $this->getColor($index, $count),
        );
    }

    abstract protected function getColor(int $index, int $count): DColor|string;

    protected function refineIndex(int $index, int $count): int
    {
        return max(0, min($index, $count - 1));
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

    protected function createVector(float $start, float $end, int $count): IGradientVector
    {
        $step = $this->calculateStep($start, $end, $count);

        return new GradientVector($start, $step);
    }

    protected function calculateStep(float $start, float $end, int $count): float
    {
        return $count === 0 ? 0.0 : ($end - $start) / abs($count);
    }
}
