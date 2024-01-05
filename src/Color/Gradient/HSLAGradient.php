<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\Vector\IVector;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IUnconvertibleColor;
use AlecRabbit\Color\Gradient\A\AGradient;
use AlecRabbit\Color\Gradient\Vector\Vector;

final readonly class HSLAGradient extends AGradient
{
    private IVector $h;
    private IVector $s;
    private IVector $l;
    private IVector $o;
    private string $format;

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
        $start = $this->toHSLA($this->range->getStart());
        $end = $this->toHSLA($this->range->getEnd());

        $this->h = Vector::create($start->getHue(), $end->getHue(), $count);
        $this->s = Vector::create($start->getSaturation(), $end->getSaturation(), $count);
        $this->l = Vector::create($start->getLightness(), $end->getLightness(), $count);
        $this->o = Vector::create($start->getOpacity(), $end->getOpacity(), $count);

        $this->format = "hsla(%s, %.0f%%, %.0f%%, %.{$this->precision}f)";
    }

    private function toHSLA(IUnconvertibleColor|string $color): IHSLAColor
    {
        return $this->ensureConvertable($color)->to(IHSLAColor::class);
    }

    protected function getColorString(int $index): string
    {
        return sprintf(
            $this->format,
            (int)round($this->h->get($index)),
            $this->s->get($index) * 100,
            $this->l->get($index) * 100,
            round($this->o->get($index), $this->precision),
        );
    }
}
