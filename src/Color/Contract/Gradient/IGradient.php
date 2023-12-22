<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

interface IGradient
{
    /**
     * @throws InvalidArgument
     */
    public function unwrap(): Traversable;

    /**
     * Returns one color from gradient by index.
     *
     * @param int $index The index of the color. Starts from 0.
     * @return IColor
     *
     * @throws InvalidArgument
     */
    public function getOne(int $index): IColor;


    public function getCount(): int;
}
