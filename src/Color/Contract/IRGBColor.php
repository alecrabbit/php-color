<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IRGBColor extends IColor,
                            IHasValue,
                            IHasRed,
                            IHasGreen,
                            IHasBlue,
                            IModifiableWithRed,
                            IModifiableWithGreen,
                            IModifiableWithBlue
{
    public const FORMAT_RGB = 'rgb(%d, %d, %d)';

    public static function fromRGB(int $r, int $g, int $b): IRGBColor;

    public static function fromDTO(DColor $dto): IRGBColor;

    public static function from(IColor $color): IRGBColor;

    public static function fromString(string $value): IRGBColor;

    public function withRed(int $red): IRGBColor;

    public function withGreen(int $green): IRGBColor;

    public function withBlue(int $blue): IRGBColor;
}
