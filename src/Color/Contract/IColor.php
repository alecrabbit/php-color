<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColor
{
    public static function fromString(string $color): IColor;

    public function toString(): string;
}
