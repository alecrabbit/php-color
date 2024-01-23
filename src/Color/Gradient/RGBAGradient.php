<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Contract\Gradient\Vector\IVector;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Gradient\A\AGradient;
use AlecRabbit\Color\Gradient\Vector\Vector;
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
            range: $range,
            count: $count,
            max: $max,
        );

        $count = $this->count - 1;
        /** @var DRGB $start */
        $start = $this->dto($this->range->getStart());
        /** @var DRGB $end */
        $end = $this->dto($this->range->getEnd());

        $this->r = Vector::create($start->red, $end->red, $count);
        $this->g = Vector::create($start->green, $end->green, $count);
        $this->b = Vector::create($start->blue, $end->blue, $count);
        $this->o = Vector::create($start->alpha, $end->alpha, $count);
    }

    private function dto(IColor|string $color): DColor
    {
        return $this->ensureColor($color)->to(DRGB::class);
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
