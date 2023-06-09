<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColorInstantiator
{
    public function fromString(string $color): IConvertableColor;
}
