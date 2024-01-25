<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Contract\Gradient\Vector\IVector;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Gradient\A\AGradient;
use AlecRabbit\Color\Gradient\Vector\Vector;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;

final readonly class HSLAGradient extends AGradient
{
    private IVector $h;
    private IVector $s;
    private IVector $l;
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

        $start = $this->dto($range->getStart(), DHSL::class);
        $end = $this->dto($range->getEnd(), DHSL::class);

        $this->h = $this->createVector($start->hue, $end->hue, $count);
        $this->s = $this->createVector($start->saturation, $end->saturation, $count);
        $this->l = $this->createVector($start->lightness, $end->lightness, $count);
        $this->o = $this->createVector($start->alpha, $end->alpha, $count);
    }

    protected function getColor(int $index): DColor
    {
        return new DHSL(
            hue: $this->h->get($index),
            saturation: $this->s->get($index),
            lightness: $this->l->get($index),
            alpha: $this->o->get($index),
        );
    }
}
