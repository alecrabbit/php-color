<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Color\Util\Converter;
use Traversable;

final readonly class Gradient implements IGradient
{
    private const MAX = 1000;
    private const MIN = 2;
    private const FLOAT_PRECISION = 2;

    public function __construct(
        private IColorRange $range,
        private int $count = self::MIN,
        private int $max = self::MAX,
        private int $precision = self::FLOAT_PRECISION,
    ) {
        $this->assertCount($count);
    }

    private function assertCount(int $count): void
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

        $count = $this->count - 1;

        $start = $this->toRGBA($this->range->getStart());
        $end = $this->toRGBA($this->range->getEnd());

        $rStep = ($end->getRed() - $start->getRed()) / $count;
        $gStep = ($end->getGreen() - $start->getGreen()) / $count;
        $bStep = ($end->getBlue() - $start->getBlue()) / $count;
        $oStep = ($end->getOpacity() - $start->getOpacity()) / $count;

        return Color::fromString(
            sprintf(
                'rgba(%s, %s, %s, %s)',
                (int)round($start->getRed() + $rStep * $index),
                (int)round($start->getGreen() + $gStep * $index),
                (int)round($start->getBlue() + $bStep * $index),
                round($start->getOpacity() + $oStep * $index, $this->precision),
            ),
        );
    }

    private function assertIndex(int $index): void
    {
        match (true) {
            $index < 0 => throw new InvalidArgument('Index must be greater than or equal 0.'),
            $index >= $this->count => throw new InvalidArgument(
                sprintf(
                    'Index must be less than %s.',
                    $this->count
                )
            ),
            default => null,
        };
    }

    private function toRGBA(IColor|string $color): IRGBAColor
    {
        if (\is_string($color)) {
            $color = Color::fromString($color);
        }
        return Converter::to(IRGBAColor::class)->convert($color);
    }

    public function getCount(): int
    {
        return $this->count;
    }

}
