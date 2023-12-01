<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IHSLColor;

class HSL extends AConvertableColor implements IHSLColor
{
    protected function __construct(
        protected int $hue,
        protected float $saturation,
        protected float $lightness,
    ) {
    }

    /** @psalm-suppress MoreSpecificReturnType */
    public static function fromString(string $color): IHSLColor
    {
        /**
         * @noinspection PhpIncompatibleReturnTypeInspection
         * @psalm-suppress LessSpecificReturnStatement
         */
        return AConvertableColor::fromString($color)->to(self::class);
    }

    public function toString(): string
    {
        return
            sprintf(
                self::FORMAT_HSL,
                $this->hue,
                round($this->saturation * 100),
                round($this->lightness * 100),
            );
    }

    public function getHue(): int
    {
        return $this->hue;
    }

    public function getSaturation(): float
    {
        return $this->saturation;
    }

    public function getLightness(): float
    {
        return $this->lightness;
    }

    public function withHue(int $hue): IHSLColor
    {
        return self::fromHSL($hue, $this->saturation, $this->lightness);
    }

    public static function fromHSL(int $hue, float $saturation = 1.0, float $lightness = 0.5): IHSLColor
    {
        return
            new self(
                self::refineHue($hue),
                self::refineValue($saturation),
                self::refineValue($lightness),
            );
    }

    protected static function refineHue(int $value): int
    {
        return ($value % 360 + 360) % 360;
    }

    protected static function refineValue(float $value): float
    {
        return round(max(0.0, min(1.0, $value)), 2);
    }

    public function withSaturation(float $saturation): IHSLColor
    {
        return self::fromHSL($this->hue, $saturation, $this->lightness);
    }

    public function withLightness(float $lightness): IHSLColor
    {
        return self::fromHSL($this->hue, $this->saturation, $lightness);
    }
}
