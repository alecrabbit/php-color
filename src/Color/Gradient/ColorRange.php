<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;


final readonly class ColorRange implements IColorRange
{
    public function __construct(
        private DColor|IColor|string $start,
        private DColor|IColor|string $end,
    ) {
    }

    public function getStart(): DColor|IColor|string
    {
        return $this->start;
    }

    public function getEnd(): DColor|IColor|string
    {
        return $this->end;
    }

    public function invert(): IColorRange
    {
        return new self($this->end, $this->start);
    }

    public function continueWith(IColor|DColor|string $to): IColorRange
    {
        return new self($this->end, $to);
    }
}
