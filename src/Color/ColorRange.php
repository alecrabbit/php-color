<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorRange;


final readonly class ColorRange implements IColorRange
{
    public function __construct(
        private IColor|string $start,
        private IColor|string $end,
    ) {
    }

    public function getStart(): IColor|string
    {
        return $this->start;
    }

    public function getEnd(): IColor|string
    {
        return $this->end;
    }
}