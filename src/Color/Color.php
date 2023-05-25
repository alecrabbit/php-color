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

        return
            new self($value);
    }

    public static function fromARGB(int $alpha, int $r, int $g, int $b): IColor
    {
        $value =
            (
                (($alpha & self::SEGMENT) << 24) |
                (($r & self::SEGMENT) << 16) |
                (($g & self::SEGMENT) << 8) |
                (($b & self::SEGMENT) << 0)
            ) & self::MAX;

        return
            new self($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getOpacity(): float
    {
        return round($this->getAlpha() / self::SEGMENT, 3);
    }

    public function getAlpha(): int
    {
        return (0xFF000000 & $this->value) >> 24;
    }

    public function getRed(): int
    {
        return (0x00FF0000 & $this->value) >> 16;
    }

    public function getGreen(): int
    {
        return (0x0000FF00 & $this->value) >> 8;
    }

    public function getBlue(): int
    {
        return (0x000000FF & $this->value) >> 0;
    }
}
