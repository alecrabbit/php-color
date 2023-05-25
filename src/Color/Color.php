<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColor;

class Color implements IColor
{
    private const MAX = 0xFFFFFFFF;
    private const SEGMENT = 0xFF;
    private int $value;

    public function __construct(int $value)
    {
        $this->value = abs($value) & self::MAX;
    }

    public static function fromRGBO(int $r, int $g, int $b, float $opacity): IColor
    {
        $value =
            (
                (((int)($opacity * self::SEGMENT) & self::SEGMENT) << 24) |
                (($r & self::SEGMENT) << 16) |
                (($g & self::SEGMENT) << 8) |
                (($b & self::SEGMENT) << 0)
            ) & self::MAX;
//        dump($value, dechex($value));
        return new Color($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
