<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColorRange
{
    public function getStart(): IColor|string;

    public function getEnd(): IColor|string;
}
