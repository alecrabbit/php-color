<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IModifiableWithOpacity
{
    public function withOpacity(float $opacity): IModifiableWithOpacity;
}
