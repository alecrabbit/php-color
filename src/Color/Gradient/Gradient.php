<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Util\Converter;
use Traversable;

final readonly class Gradient implements IGradient
{
    private const MAX = 1000;
    private const MIN = 2;
    private const FLOAT_PRECISION = 2;

    public function __construct(
        private int $maxColors = self::MAX,
        private int $floatPrecision = self::FLOAT_PRECISION,
    ) {
    }

    /** @inheritDoc */
    public function create(IColor|string $start, IColor|string $end, int $count = 2): Traversable
    {
        $this->assertCount($count);

        $count--;

        $start = $this->toRGBA($start);
        $end = $this->toRGBA($end);

        $rStep = ($end->getRed() - $start->getRed()) / $count;
        $gStep = ($end->getGreen() - $start->getGreen()) / $count;
        $bStep = ($end->getBlue() - $start->getBlue()) / $count;
        $oStep = ($end->getOpacity() - $start->getOpacity()) / $count;

        for ($i = 0; $i < $count; $i++) {
            yield RGBA::fromRGBO(
                (int)round($start->getRed() + $rStep * $i),
                (int)round($start->getGreen() + $gStep * $i),
                (int)round($start->getBlue() + $bStep * $i),
                round($start->getOpacity() + $oStep * $i, $this->floatPrecision),
            );
        }

        yield $end;
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

    private function toRGBA(IColor|string $from): IRGBAColor
    {
        if ($from instanceof IColor) {
            return Converter::to(RGBA::class)->convert($from);
        }
        return RGBA::fromString($from);
    }
}
