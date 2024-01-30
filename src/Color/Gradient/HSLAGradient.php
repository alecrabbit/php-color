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
            hue: $this->createVector($this->start->hue, $this->end->hue, $count)->get($index),
            saturation: $this->createVector($this->start->saturation, $this->end->saturation, $count)->get($index),
            lightness: $this->createVector($this->start->lightness, $this->end->lightness, $count)->get($index),
            alpha: $this->createVector($this->start->alpha, $this->end->alpha, $count)->get($index),
        );
    }
}
