<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient\A;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Util\Color;
use Traversable;

abstract readonly class AGradient implements IGradient
{
    protected const MAX = 1000;
    protected const MIN = 2;
    protected const FLOAT_PRECISION = 2;

    public function __construct(
        protected IColorRange $range,
        protected int $count,
        protected int $max,
        protected int $precision,
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

    /**
     * @inheritDoc
     */
    public function getOne(int $index): IColor
    {
        $this->assertIndex($index);

        return $this->createColor($index);
    }

    protected function assertIndex(int $index): void
    {
        match (true) {
            $index < 0 => throw new InvalidArgument('Index must be greater than or equal 0.'),
            $index >= $this->count => throw new InvalidArgument(
                sprintf(
                    'Index(%s) must be less than count(%s).',
                    $index,
                    $this->count
                )
            ),
            default => null,
        };
    }

    protected function ensureConvertable(IColor|string $color): IConvertableColor
    {
        if ($color instanceof IConvertableColor) {
            return $color;
        }

        if (!is_string($color)) {
            $color = $color->toString();
        }

        return Color::fromString($color);
    }
}
