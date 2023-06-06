<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IHSLColor
{

    public function getHue(): int;

    public function getSaturation(): float;

    public function getLightness(): float;
}
