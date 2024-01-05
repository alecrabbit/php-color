<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\Vector\IVector;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IUnconvertibleColor;
use AlecRabbit\Color\Gradient\A\AGradient;
use AlecRabbit\Color\Gradient\Vector\Vector;

final readonly class RGBAGradient extends AGradient
{
    private IVector $r;
    private IVector $g;
    private IVector $b;
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
        $start = $this->toRGBA($this->range->getStart());
        $end = $this->toRGBA($this->range->getEnd());

        $this->r = Vector::create($start->getRed(), $end->getRed(), $count);
        $this->g = Vector::create($start->getGreen(), $end->getGreen(), $count);
        $this->b = Vector::create($start->getBlue(), $end->getBlue(), $count);
        $this->o = Vector::create($start->getOpacity(), $end->getOpacity(), $count);

        $this->format = "rgba(%s, %s, %s, %.{$this->precision}f)";
    }

    private function toRGBA(IUnconvertibleColor|string $color): IRGBAColor
    {
        return $this->ensureConvertable($color)->to(IRGBAColor::class);
    }

    protected function getColorString(int $index): string
    {
        return sprintf(
            $this->format,
            (int)round($this->r->get($index)),
            (int)round($this->g->get($index)),
            (int)round($this->b->get($index)),
            round($this->o->get($index), $this->precision),
        );
    }
}
