<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

interface IGradients
{
    /**
     * Generates gradients of colors between pairs of colors.
     *
     * @param Traversable<IColor|string> $colors Colors to generate gradients.
     * @param int $num The number of colors between supplied colors. Minimum 2.
     * @param IColor|string|null $start Optional. The starting color of the gradient.
     *
     * @return Traversable<IColor>
     *
     * @throws InvalidArgument
     */
    public function create(Traversable $colors, int $num = 2, IColor|string|null $start = null): Traversable;

}
