<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColor
{
    public const SEGMENT = 0xFF;
    public const MAX = 0xFFFFFFFF;
    public const PRECISION = 3;

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IColor;

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = self::SEGMENT): IColor;

}
