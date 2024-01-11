<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IHSLColor extends IColor,
                            IHasHue,
                            IHasSaturation,
                            IHasLightness,
                            IModifiableWithHue,
                            IModifiableWithSaturation,
                            IModifiableWithLightness
{
    public const FORMAT_HSL = 'hsl(%d, %s%%, %s%%)';

    public static function fromHSL(int $hue, float $saturation = 1.0, float $lightness = 0.5): IHSLColor;

    public function withHue(int $hue): IHSLColor;

    public function withSaturation(float $saturation): IHSLColor;

    public function withLightness(float $lightness): IHSLColor;
}
