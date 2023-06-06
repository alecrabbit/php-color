<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\RGBA;

interface IRGBAColor extends IRGBColor, HasAlpha, HasOpacity
{
    public static function fromRGBA(int $r, int $g, int $b, int $alpha = 0xFF): IRGBAColor;

    public function withRed(int $red): IRGBAColor;

    public function withGreen(int $green): IRGBAColor;

    public function withBlue(int $blue): IRGBAColor;

    public function withAlpha(int $alpha): IRGBAColor;

    public function withOpacity(float $opacity): IRGBAColor;
}
