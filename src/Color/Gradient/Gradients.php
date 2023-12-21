<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Gradient;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\Gradient\IGradients;
use AlecRabbit\Color\Contract\IColor;
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
            if ($start === null) {
                $start = $color;
                continue;
            }
            yield from $this->gradient->create($start, $color, $num);
            $start = $color;
        }
    }
}
