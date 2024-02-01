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
            red: $this->createVector($this->start->red, $this->end->red, $count)->get($index),
            green: $this->createVector($this->start->green, $this->end->green, $count)->get($index),
            blue: $this->createVector($this->start->blue, $this->end->blue, $count)->get($index),
            alpha: $this->createVector($this->start->alpha, $this->end->alpha, $count)->get($index),
        );
    }
}
