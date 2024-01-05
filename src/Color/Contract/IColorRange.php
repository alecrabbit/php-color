<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColorRange
{
    public function getStart(): IUnconvertibleColor|string;

    public function getEnd(): IUnconvertibleColor|string;
}
