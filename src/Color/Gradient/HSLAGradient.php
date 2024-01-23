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
            range: $range,
            count: $count,
            max: $max,
        );

        $count = $this->count - 1;
        /** @var DHSL $start */
        $start = $this->dto($this->range->getStart());
        /** @var DHSL $end */
        $end = $this->dto($this->range->getEnd());

        $this->h = Vector::create($start->hue, $end->hue, $count);
        $this->s = Vector::create($start->saturation, $end->saturation, $count);
        $this->l = Vector::create($start->lightness, $end->lightness, $count);
        $this->o = Vector::create($start->alpha, $end->alpha, $count);
    }

    private function dto(IColor|string $color): DColor
    {
        return $this->ensureColor($color)->to(DHSL::class);
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
