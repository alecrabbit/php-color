<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Contract\Gradient\Vector\IVector;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Gradient\A\AGradient;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;

final readonly class RGBAGradient extends AGradient
{
    private IVector $r;
    private IVector $g;
    private IVector $b;
    private IVector $o;

    public function __construct(
        IColorRange $range,
        int $count = self::MIN,
        int $max = self::MAX,
    ) {
        parent::__construct(
            count: $count,
            max: $max,
        );

        $count = $this->count - 1;

        $start = $this->dto($range->getStart(), DRGB::class);
        $end = $this->dto($range->getEnd(), DRGB::class);

        $this->r = $this->createVector($start->red, $end->red, $count);
        $this->g = $this->createVector($start->green, $end->green, $count);
        $this->b = $this->createVector($start->blue, $end->blue, $count);
        $this->o = $this->createVector($start->alpha, $end->alpha, $count);
    }

    protected function getColor(int $index): DColor
    {
        return new DRGB(
            red: $this->r->get($index),
            green: $this->g->get($index),
            blue: $this->b->get($index),
            alpha: $this->o->get($index),
        );
    }
}
