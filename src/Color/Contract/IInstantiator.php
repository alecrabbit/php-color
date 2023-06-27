<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IInstantiator
{
    public function fromString(string $color): IConvertableColor;
}
