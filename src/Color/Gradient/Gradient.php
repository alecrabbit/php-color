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
use AlecRabbit\Color\Util\Color;
use Traversable;

use function is_string;

final readonly class Gradient implements IGradient
{
    private const MAX = 1000;
    private const MIN = 2;
    private const FLOAT_PRECISION = 2;
    private DRGBO $start;
    private float $rStep;
    private float $gStep;
    private float $bStep;
    private float $oStep;

    public function __construct(
        private IColorRange $range,
        private int $count = self::MIN,
        private int $max = self::MAX,
        private int $precision = self::FLOAT_PRECISION,
    ) {
        $this->assertCount($count);

        $this->start = $this->toDTO($this->range->getStart());
        $end = $this->toRGBA($this->range->getEnd());

        $count = $this->count - 1;

        $this->rStep = ($end->getRed() - $this->start->red) / $count;
        $this->gStep = ($end->getGreen() - $this->start->green) / $count;
        $this->bStep = ($end->getBlue() - $this->start->blue) / $count;
        $this->oStep = ($end->getOpacity() - $this->start->opacity) / $count;
    }

    private function assertCount(int $count): void
    {
        match (true) {
            $count < self::MIN => throw new InvalidArgument(
                sprintf('Number of colors must be greater than %s.', self::MIN)
            ),
            $count > $this->max => throw new InvalidArgument(
                sprintf('Number of colors must be less than %s.', $this->max)
            ),
            default => null,
        };
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

    protected function ensureConvertable(IColor|string $color): IConvertableColor
    {
        if ($color instanceof IConvertableColor) {
            return $color;
        }

        if (!is_string($color)) {
            $color = $color->toString();
        }

        return Color::fromString($color);
    }

    /** @inheritDoc */
    public function unwrap(): Traversable
    {
        for ($i = 0; $i < $this->count; $i++) {
            yield $this->getOne($i);
        }
    }

    /**
     * @inheritDoc
     */
    public function getOne(int $index): IColor
    {
        $this->assertIndex($index);

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

    private function assertIndex(int $index): void
    {
        match (true) {
            $index < 0 => throw new InvalidArgument('Index must be greater than or equal 0.'),
            $index >= $this->count => throw new InvalidArgument(
                sprintf(
                    'Index(%s) must be less than count(%s).',
                    $index,
                    $this->count
                )
            ),
            default => null,
        };
    }

    public function getCount(): int
    {
        return $this->count;
    }

}
