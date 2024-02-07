<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Gradient\A\AGradient;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;

final readonly class RGBAGradient extends AGradient
{
    private DRGB $start;
    private DRGB $end;

    public function __construct(
        IColorRange $range,
    ) {
        $this->start = $this->dto($range->getStart(), DRGB::class);
        $this->end = $this->dto($range->getEnd(), DRGB::class);
    }

    protected function getColor(int $index, int $count): DColor
    {
        $count--;

        return new DRGB(
            r: $this->createVector($this->start->r, $this->end->r, $count)->get($index),
            g: $this->createVector($this->start->g, $this->end->g, $count)->get($index),
            b: $this->createVector($this->start->b, $this->end->b, $count)->get($index),
            alpha: $this->createVector($this->start->alpha, $this->end->alpha, $count)->get($index),
        );
    }
}
