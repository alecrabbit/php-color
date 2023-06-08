<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IModifiableWithLightness
{
    public function withLightness(float $lightness): IModifiableWithLightness;
}
