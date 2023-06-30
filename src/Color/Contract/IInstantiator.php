<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IInstantiator
{
    public static function isSupported(string $color): bool;

    public function fromString(string $color): IConvertableColor;
}
