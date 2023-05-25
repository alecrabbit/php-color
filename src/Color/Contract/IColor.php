<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Color;

interface IColor
{
    public static function fromRGBO(int $r, int $g, int $b, float $opacity): IColor;

    public static function fromARGB(int $alpha, int $r, int $g, int $b): IColor;

    public function getValue(): int;
}
