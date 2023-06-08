<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IHSLColor extends IConvertableColor,
                            IHasHue,
                            IHasSaturation,
                            IHasLightness,
                            IModifiableWithHue,
                            IModifiableWithSaturation,
                            IModifiableWithLightness
{
    public static function fromHSL(int $hue, float $saturation = 1.0, float $lightness = 0.5): IHSLColor;

    public function withHue(int $hue): IHSLColor;

    public function withSaturation(float $saturation): IHSLColor;

    public function withLightness(float $lightness): IHSLColor;
}