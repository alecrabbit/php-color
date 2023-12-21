<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\ColorRange;
use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\Gradient\IGradients;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

final readonly class Gradients implements IGradients
{
    public function __construct(
        private IGradient $gradient,
    ) {
    }

    /** @inheritDoc */
    public function create(Traversable $colors, int $num = 2, IColor|string|null $start = null): Traversable
    {
        foreach ($colors as $color) {
            self::assertColor($color);
            if ($start === null) {
                $start = $color;
                continue;
            }
            yield from $this->gradient->unwrap($this->createRange($start, $color, $num));
            $start = $color;
        }
    }

    private static function assertColor(mixed $color): void
    {
        match (true) {
            is_string($color), $color instanceof IColor => null,
            default => throw new InvalidArgument(
                sprintf('Color must be instance of %s or string.', IColor::class)
            )
        };
    }

    private function createRange(IColor|string $start, IColor|string $color, int $num): IColorRange
    {
        return new ColorRange($start, $color, $num);
    }
}
