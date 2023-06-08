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
    public static function fromInteger(int $value): IHexColor;

    public function withRed(int $red): IHexColor;

    public function withGreen(int $green): IHexColor;

    public function withBlue(int $blue): IHexColor;
}
