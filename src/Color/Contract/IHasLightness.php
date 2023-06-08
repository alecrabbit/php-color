<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IHasLightness
{
    public function getLightness(): float;
}
