<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IColor;
use Traversable;

/**
 * @template-covariant T of IColor
 */
interface IToConverter
{
    /**
     * Returns traversable of color classes/interfaces for which this converter is applicable.
     *
     * @return Traversable<class-string<T>>
     */
    public static function getTargets(): Traversable;

    /**
     * @psalm-return T
     */
    public function convert(IColor $color): IColor;
}
