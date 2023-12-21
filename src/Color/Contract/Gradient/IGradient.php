<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

interface IGradient
{
    /**
     * Generates a gradient of colors between two colors.
     *
     * @param IColorRange $range Color range of the gradient.
     *
     * @return Traversable<IColor>
     *
     * @throws InvalidArgument
     */
    public function unwrap(IColorRange $range): Traversable;

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
     *
     * // FIXME (2023-12-21 18:58) [Alec Rabbit]: move this method to other class [702ab3fb-a914-4384-921c-54381f26c5c7]
     *     like __construct(IColorRange $range) and $class->getOne($index)
     *     this will allow to calculate  r,g,b steps only once
     *
     */
    public function getOne(int $index, IColor|string $start, IColor|string $end, int $count = 100): IColor;
}
