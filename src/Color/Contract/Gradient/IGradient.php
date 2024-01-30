<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

interface IGradient
{
    /**
     * Unwraps gradient to traversable of colors.
     *
     * @param int $count The total number of colors.
     *
     * @return Traversable<IColor>
     *
     * @throws InvalidArgument
     */
    public function unwrap(int $count): Traversable;

    /**
     * Returns one color from gradient by index.
     *
     * @param int $index The index of the color. Starts from 0.
     * @param int $count The total number of colors.
     *
     * @return IColor
     *
     * @throws InvalidArgument
     */
    public function getOne(int $index, int $count = 100): IColor;
}
