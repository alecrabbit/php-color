<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Contract\Gradient\Vector\IVector;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLAColor;
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
        int $precision = self::FLOAT_PRECISION,
    ) {
        parent::__construct(
            range: $range,
            count: $count,
            max: $max,
            precision: $precision,
        );

        $count = $this->count - 1;
        /** @var IHSLAColor $start */
        $start = $this->toHSLA($this->range->getStart());
        /** @var IHSLAColor $end */
        $end = $this->toHSLA($this->range->getEnd());

        $this->h = Vector::create($start->getHue() / 360, $end->getHue() / 360, $count);
        $this->s = Vector::create($start->getSaturation(), $end->getSaturation(), $count);
        $this->l = Vector::create($start->getLightness(), $end->getLightness(), $count);
        $this->o = Vector::create($start->getOpacity(), $end->getOpacity(), $count);
    }

    private function toHSLA(IColor|string $color): IColor
    {
        return $this->ensureConvertable($color)->to(IHSLAColor::class);
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
