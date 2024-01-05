<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Instantiator;

use AlecRabbit\Color\Contract\IColor;

interface IInstantiator
{
    public static function isSupported(string $color): bool;

    public function fromString(string $color): IColor;
}
