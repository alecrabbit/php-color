<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Gradient\A\AGradient;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;

final readonly class HSLAGradient extends AGradient
{
    private DHSL $start;
    private DHSL $end;

    public function __construct(
        IColorRange $range,
    ) {
        $this->start = $this->dto($range->getStart(), DHSL::class);
        $this->end = $this->dto($range->getEnd(), DHSL::class);
    }

    protected function getColor(int $index, int $count): DColor
    {
        $count--;

        return new DHSL(
            h: $this->createVector($this->start->h, $this->end->h, $count)->get($index),
            s: $this->createVector($this->start->s, $this->end->s, $count)->get($index),
            l: $this->createVector($this->start->l, $this->end->l, $count)->get($index),
            alpha: $this->createVector($this->start->alpha, $this->end->alpha, $count)->get($index),
        );
    }
}
