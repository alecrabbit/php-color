<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;

class HSLA extends HSL implements IHSLAColor
{
    protected function __construct(
        int $hue,
        float $saturation,
        float $lightness,
        protected float $alpha,
    ) {
        parent::__construct($hue, $saturation, $lightness);
    }

    protected static function createFromDTO(DColor $dto): IHSLAColor
    {
        /** @var DHSL $dto */
        return self::fromHSLA(
            (int)round($dto->hue * 360),
            $dto->saturation,
            $dto->lightness,
            $dto->alpha,
        );
    }

    public static function fromHSLA(
        int $hue,
        float $saturation = 1.0,
        float $lightness = 0.5,
        float $alpha = 1.0,
    ): IHSLAColor {
        return new self(
            self::refineHue($hue),
            self::refineValue($saturation),
            self::refineValue($lightness),
            self::refineValue($alpha),
        );
    }

    public function toString(): string
    {
        return
            sprintf(
                (string)static::FORMAT_HSLA,
                $this->hue,
                round($this->saturation * 100),
                round($this->lightness * 100),
                $this->alpha,
            );
    }

    public function withHue(int $hue): IHSLAColor
    {
        return self::fromHSLA($hue, $this->saturation, $this->lightness, $this->alpha);
    }

    public function withSaturation(float $saturation): IHSLAColor
    {
        return self::fromHSL($this->hue, $saturation, $this->lightness);
    }

    public static function fromHSL(int $hue, float $saturation = 1.0, float $lightness = 0.5): IHSLAColor
    {
        return
            self::fromHSLA($hue, $saturation, $lightness);
    }

    public function withLightness(float $lightness): IHSLAColor
    {
        return self::fromHSL($this->hue, $this->saturation, $lightness);
    }

    public function getAlpha(): int
    {
        return (int)round($this->getOpacity() * self::COMPONENT);
    }

    public function getOpacity(): float
    {
        return $this->alpha;
    }

    public function withOpacity(float $opacity): IHSLAColor
    {
        return self::fromHSLA($this->hue, $this->saturation, $this->lightness, $opacity);
    }

    public function withAlpha(int $alpha): IHSLAColor
    {
        return self::fromHSLA($this->hue, $this->saturation, $this->lightness, $alpha / self::COMPONENT);
    }
}
