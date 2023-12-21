<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

interface IGradient
{
    /**
     * Generates a gradient of colors between two colors.
     *
     * @param IColor|string $start The starting color of the gradient.
     * @param IColor|string $end The ending color of the gradient.
     * @param int $count The number of colors in the resulting gradient. Minimum 2.
     *
     * @return Traversable<IColor>
     *
     * @throws InvalidArgument
     */
    public function create(IColor|string $start, IColor|string $end, int $count = 2): Traversable;

    /**
     * Returns one color from gradient by index.
     *
     * @param int $index The index of the color. Starts from 0.
     * @param IColor|string $start The starting color of the gradient.
     * @param IColor|string $end The ending color of the gradient.
     * @param int $count The number of colors in the resulting gradient. Minimum 2.
     *
     * @return IColor
     *
     * @throws InvalidArgument
     */
    public function getOne(int $index, IColor|string $start, IColor|string $end, int $count = 100): IColor;
}
