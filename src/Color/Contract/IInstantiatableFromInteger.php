<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IInstantiatableFromInteger
{
    public static function fromInteger(int $value): IColor;
}
