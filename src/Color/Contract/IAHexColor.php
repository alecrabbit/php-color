<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IAHexColor extends IHexColor,
                             IHasValue8,
                             IHasAlpha,
                             IHasOpacity,
                             IModifiableWithAlpha,
                             IModifiableWithOpacity
{
    public const FORMAT_AHEX = '#%02x%06x';

    public static function fromInteger(int $value): IAHexColor;

//    public static function fromInteger8(int $value8): IAHexColor;

    public static function fromRGB(int $r, int $g, int $b): IAHexColor;

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = 0xFF): IAHexColor;

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IAHexColor;

    public function withRed(int $red): IAHexColor;

    public function withGreen(int $green): IAHexColor;

    public function withBlue(int $blue): IAHexColor;

    public function withAlpha(int $alpha): IAHexColor;

    public function withOpacity(float $opacity): IAHexColor;
}
