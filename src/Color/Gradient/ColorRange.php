<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Contract\IUnconvertibleColor;


final readonly class ColorRange implements IColorRange
{
    public function __construct(
        private IUnconvertibleColor|string $start,
        private IUnconvertibleColor|string $end,
    ) {
    }

    public function getStart(): IUnconvertibleColor|string
    {
        return $this->start;
    }

    public function getEnd(): IUnconvertibleColor|string
    {
        return $this->end;
    }
}
