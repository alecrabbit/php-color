<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient;

use AlecRabbit\Color\Contract\IColor;

interface IColorRange
{
    public function getStart(): IColor|string;

    public function getEnd(): IColor|string;
}
