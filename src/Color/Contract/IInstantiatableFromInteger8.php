<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IInstantiatableFromInteger8
{
    public static function fromInteger8(int $value8): IColor;
}
