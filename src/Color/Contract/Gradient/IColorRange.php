<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IColorRange
{
    public function getStart(): DColor|IColor|string;

    public function getEnd(): DColor|IColor|string;
}
