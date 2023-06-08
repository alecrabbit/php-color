<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IHSLAColor extends IHSLColor, HasAlpha, HasOpacity
{
    public static function fromHSLA(
        int $hue,
        float $saturation = 1.0,
        float $lightness = 0.5,
        float $alpha = 1.0,
    ): IHSLAColor;

    public function withHue(int $hue): IHSLAColor;

    public function withSaturation(float $saturation): IHSLAColor;

    public function withLightness(float $lightness): IHSLAColor;

    public function withOpacity(float $opacity): IHSLAColor;

    public function withAlpha(int $alpha): IHSLAColor;
}
