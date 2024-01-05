<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient;

use AlecRabbit\Color\Contract\IUnconvertibleColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

interface IGradient
{
    /**
     * Unwraps gradient to traversable of colors.
     *
     * @return Traversable<IUnconvertibleColor>
     *
     * @throws InvalidArgument
     */
    public function unwrap(): Traversable;

    /**
     * Returns one color from gradient by index.
     *
     * @param int $index The index of the color. Starts from 0.
     *
     * @return IUnconvertibleColor
     *
     * @throws InvalidArgument
     */
    public function getOne(int $index): IUnconvertibleColor;


    public function getCount(): int;
}
