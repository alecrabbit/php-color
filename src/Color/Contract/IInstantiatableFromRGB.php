<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IInstantiatableFromRGB
{
    public static function fromRGB(int $r, int $g, int $b): IColor;
}
