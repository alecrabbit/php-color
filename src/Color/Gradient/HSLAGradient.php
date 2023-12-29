<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\DTO\DHSLO;
use AlecRabbit\Color\DTO\DRGBO;
use AlecRabbit\Color\Gradient\A\AGradient;
use AlecRabbit\Color\Util\Color;

final readonly class HSLAGradient extends AGradient
{
    private DHSLO $start;
    private float $hStep;
    private float $sStep;
    private float $lStep;
    private float $oStep;

    public function __construct(
        IColorRange $range,
        int $count = self::MIN,
        int $max = self::MAX,
        int $precision = self::FLOAT_PRECISION,
    ) {
        parent::__construct(
            range: $range,
            count: $count,
            max: $max,
            precision: $precision,
        );

        $this->start = $this->toDTO($this->range->getStart());
        $end = $this->toHSLA($this->range->getEnd());

        $count = $this->count - 1;

        $this->hStep = ($end->getHue() - $this->start->hue) / $count;
        $this->sStep = ($end->getSaturation() - $this->start->saturation) / $count;
        $this->lStep = ($end->getLightness() - $this->start->lightness) / $count;
        $this->oStep = ($end->getOpacity() - $this->start->opacity) / $count;
    }


    private function toDTO(IColor|string $color): DHSLO
    {
        $hsla = $this->toHSLA($color);

        return new DHSLO(
            $hsla->getHue(),
            $hsla->getSaturation(),
            $hsla->getLightness(),
            $hsla->getOpacity(),
        );
    }

    private function toHSLA(IColor|string $color): IHSLAColor
    {
        return $this->ensureConvertable($color)->to(IHSLAColor::class);
    }

    public function getCount(): int
    {
        return $this->count;
    }

    protected function createColor(int $index): IConvertableColor
    {
        return Color::fromString(
            sprintf(
                "hsla(%s, %.0f%%, %.0f%%, %.{$this->precision}f)",
                ($this->start->hue + $this->hStep * $index) * 100,
                ($this->start->saturation + $this->sStep * $index) * 100,
                ($this->start->lightness + $this->lStep * $index) * 100,
                round($this->start->opacity + $this->oStep * $index, $this->precision),
            ),
        );
    }

}
