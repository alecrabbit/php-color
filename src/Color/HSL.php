<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\AColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHasOpacity;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\ModelHSL;


class HSL extends AColor implements IHSLColor
{
    protected function __construct(
        protected int $hue,
        protected float $saturation,
        protected float $lightness,
    ) {
        parent::__construct(
            colorModel: new ModelHSL(),
        );
    }

    public static function from(IColor $color): IHSLColor
    {
        return $color->to(IHSLColor::class);
    }

    public static function fromString(string $value): IHSLColor
    {
        return self::getFromString($value)->to(self::class);
    }

    public static function fromDTO(IColorDTO $dto): IHSLColor
    {
        self::assertDTO($dto);

        /** @var DHSL $dto */
        return self::fromHSL(
            (int)round($dto->hue * 360),
            $dto->saturation,
            $dto->lightness,
        );
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
        return $value === 360 ? 360 : ($value % 360 + 360) % 360;
    }

    protected static function refineValue(float $value): float
    {
        return round(max(0.0, min(1.0, $value)), 2);
    }

    protected static function dtoType(): string
    {
        return DHSL::class;
    }

    public function toDTO(): IColorDTO
    {
        return new DHSL(
            hue: round($this->getHue() / 360, self::CALC_PRECISION),
            saturation: $this->getSaturation(),
            lightness: $this->getLightness(),
            alpha: $this instanceof IHasOpacity ? $this->getOpacity() : 1.0,
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

    public function toString(): string
    {
        return
            sprintf(
                (string)static::FORMAT_HSL,
                $this->hue,
                round($this->saturation * 100),
                round($this->lightness * 100),
            );
    }

    public function withHue(int $hue): IHSLColor
    {
        return self::fromHSL($hue, $this->saturation, $this->lightness);
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
