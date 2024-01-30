<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Gradient;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IColorRange
{
    /**
     * Gets the start color of the range.
     *
     * @return DColor|IColor|string The start color.
     */
    public function getStart(): DColor|IColor|string;

    /**
     * Gets the end color of the range.
     *
     * @return DColor|IColor|string The end color.
     */
    public function getEnd(): DColor|IColor|string;

    /**
     * Creates a new instance with inverted start and end colors.
     *
     * @return IColorRange The new color range with inverted colors.
     */
    public function invert(): IColorRange;

    /**
     * Creates a new instance with the start color from the previous end color
     * and the end color set to the provided color.
     *
     * @param DColor|IColor|string $to The color to set as the end color.
     * @return IColorRange The new color range with updated colors.
     */
    public function continueWith(DColor|IColor|string $to): IColorRange;
}
