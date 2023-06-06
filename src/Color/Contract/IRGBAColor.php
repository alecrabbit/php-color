<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IRGBAColor extends IRGBColor, HasAlpha, HasOpacity
{
    public function withRed(int $red): IRGBAColor;

    public function withGreen(int $green): IRGBAColor;

    public function withBlue(int $blue): IRGBAColor;

    public function withAlpha(int $alpha): IRGBAColor;

    public function withOpacity(float $opacity): IRGBAColor;
}
