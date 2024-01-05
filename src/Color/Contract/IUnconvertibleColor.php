<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IUnconvertibleColor
{
    public static function fromString(string $color): IUnconvertibleColor;

    public function toString(): string;
}
