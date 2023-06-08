<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IRGBAColor extends IRGBColor, IHasAlpha, IHasOpacity
{
    public static function fromRGBA(int $r, int $g, int $b, int $alpha = 0xFF): IRGBAColor;

    public function withRed(int $red): IRGBAColor;

    public function withGreen(int $green): IRGBAColor;

    public function withBlue(int $blue): IRGBAColor;

    public function withAlpha(int $alpha): IRGBAColor;

    public function withOpacity(float $opacity): IRGBAColor;
}
