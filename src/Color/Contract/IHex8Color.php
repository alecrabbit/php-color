<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IHex8Color extends IHexColor,
                             IHasValue8,
                             IHasAlpha,
                             IHasOpacity,
                             IInstantiatableFromInteger8,
                             IModifiableWithAlpha,
                             IModifiableWithOpacity
{
    public const FORMAT_HEX8 = '#%06x%02x';

    public static function fromInteger(int $value, ?int $alpha = null): IHex8Color;

    public static function fromInteger8(int $value8): IHex8Color;

    public static function fromRGB(int $r, int $g, int $b): IHex8Color;

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = 0xFF): IHex8Color;

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IHex8Color;

    public function withRed(int $red): IHex8Color;

    public function withGreen(int $green): IHex8Color;

    public function withBlue(int $blue): IHex8Color;

    public function withAlpha(int $alpha): IHex8Color;

    public function withOpacity(float $opacity): IHex8Color;
}
