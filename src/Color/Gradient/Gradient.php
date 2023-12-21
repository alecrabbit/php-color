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

    // FIXME (2023-12-21 19:16) [Alec Rabbit]: [702ab3fb-a914-4384-921c-54381f26c5c7] or here
    public function __construct(
        private int $maxColors = self::MAX,
        private int $floatPrecision = self::FLOAT_PRECISION,
    ) {
    }

    /** @inheritDoc */
    public function unwrap(IColorRange $range): Traversable
    {
        $count = $range->getCount();
        for ($i = 0; $i < $count; $i++) {
            yield $this->getOne($i, $range->getStart(), $range->getEnd(), $count);
        }
    }

    /**
     * @inheritDoc
     */
    public function getOne(
        int $index,
        IColor|string $start = '#000',
        IColor|string $end = '#fff',
        int $count = 100
    ): IColor {
        $this->assertCount($count);
        $this->assertIndex($index, $count);

        $count--;

        $start = $this->toRGBA($start);
        $end = $this->toRGBA($end);

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
                round($start->getOpacity() + $oStep * $index, $this->floatPrecision),
            ),
        );
    }

    private function assertCount(int $count): void
    {
        match (true) {
            $count < self::MIN => throw new InvalidArgument(
                sprintf('Number of colors must be greater than %s.', self::MIN)
            ),
            $count > $this->maxColors => throw new InvalidArgument(
                sprintf('Number of colors must be less than %s.', $this->maxColors)
            ),
            default => null,
        };
    }

    private function assertIndex(int $index, int $count): void
    {
        match (true) {
            $index < 0 => throw new InvalidArgument('Index must be greater than or equal 0.'),
            $index >= $count => throw new InvalidArgument(
                sprintf(
                    'Index must be less than %s.',
                    $count
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

}
