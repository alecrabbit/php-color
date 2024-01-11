<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IHasFromString
{
    public static function fromString(string $value): IHasFromString;
}
