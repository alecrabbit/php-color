<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use Traversable;

/**
 * @template-covariant T of IColor
 */
interface IToConverter extends IColorConverter
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
