<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Contract\Gradient\Vector\IVector;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
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
        /** @var IRGBAColor $start */
        $start = $this->toRGBA($this->range->getStart());
        /** @var IRGBAColor $end */
        $end = $this->toRGBA($this->range->getEnd());

        $this->r = Vector::create($start->getRed() / 255, $end->getRed()/ 255, $count);
        $this->g = Vector::create($start->getGreen()/ 255, $end->getGreen()/ 255, $count);
        $this->b = Vector::create($start->getBlue()/ 255, $end->getBlue()/ 255, $count);
        $this->o = Vector::create($start->getOpacity(), $end->getOpacity(), $count);
    }

    private function toRGBA(IColor|string $color): IColor
    {
        return $this->ensureConvertable($color)->to(IRGBAColor::class);
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
