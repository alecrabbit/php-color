<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IRGBColor extends IConvertableColor,
                            IHasValue,
                            IHasRed,
                            IHasGreen,
                            IHasBlue,
                            IModifiableWithRed,
                            IModifiableWithGreen,
                            IModifiableWithBlue
{
    public static function fromRGB(int $r, int $g, int $b): IRGBColor;

    public function withRed(int $red): IRGBColor;

    public function withGreen(int $green): IRGBColor;

    public function withBlue(int $blue): IRGBColor;
}
