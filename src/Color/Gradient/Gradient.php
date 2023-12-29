<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\DTO\DRGBO;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Gradient\A\AGradient;
use AlecRabbit\Color\Util\Color;
use Traversable;

use function is_string;

final readonly class Gradient extends AGradient
{
    private DRGBO $start;
    private float $rStep;
    private float $gStep;
    private float $bStep;
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
        $end = $this->toRGBA($this->range->getEnd());

        $count = $this->count - 1;

        $this->rStep = ($end->getRed() - $this->start->red) / $count;
        $this->gStep = ($end->getGreen() - $this->start->green) / $count;
        $this->bStep = ($end->getBlue() - $this->start->blue) / $count;
        $this->oStep = ($end->getOpacity() - $this->start->opacity) / $count;
    }



    private function toDTO(IColor|string $color): DRGBO
    {
        $rgba = $this->toRGBA($color);

        return new DRGBO(
            $rgba->getRed(),
            $rgba->getGreen(),
            $rgba->getBlue(),
            $rgba->getOpacity(),
        );
    }

    private function toRGBA(IColor|string $color): IRGBAColor
    {
        return $this->ensureConvertable($color)->to(IRGBAColor::class);
    }

    public function getCount(): int
    {
        return $this->count;
    }

    protected function createColor(int $index): IConvertableColor
    {
        return Color::fromString(
            sprintf(
                'rgba(%s, %s, %s, %s)',
                (int)round($this->start->red + $this->rStep * $index),
                (int)round($this->start->green + $this->gStep * $index),
                (int)round($this->start->blue + $this->bStep * $index),
                round($this->start->opacity + $this->oStep * $index, $this->precision),
            ),
        );
    }

}
