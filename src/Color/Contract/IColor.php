<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColor
{
    public function fromString(string $color): IColor;
}
