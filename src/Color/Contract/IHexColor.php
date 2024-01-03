<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IHexColor extends IConvertableColor,
                            IHasValue,
                            IHasRed,
                            IHasGreen,
                            IHasBlue,
                            IModifiableWithRed,
                            IModifiableWithGreen,
                            IModifiableWithBlue
{
    public const FORMAT_HEX = '#%06x';

    public static function fromInteger(int $value): IHexColor;

    public static function fromRGB(int $r, int $g, int $b): IHexColor;

    public function withRed(int $red): IHexColor;

    public function withGreen(int $green): IHexColor;

    public function withBlue(int $blue): IHexColor;
}
