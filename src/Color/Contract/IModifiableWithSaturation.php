<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IModifiableWithSaturation
{
    public function withSaturation(float $saturation): IModifiableWithSaturation;
}
