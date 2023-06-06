<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IRGBColor extends IConvertableColor
{
    public static function fromRGB(int $r, int $g, int $b): IRGBColor;

    public function getValue(): int;

    public function getRed(): int;

    public function getGreen(): int;

    public function getBlue(): int;

    public function withRed(int $red): IRGBColor;

    public function withGreen(int $green): IRGBColor;

    public function withBlue(int $blue): IRGBColor;
}
