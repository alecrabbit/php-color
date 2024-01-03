<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;
use Traversable;

interface IToConverter
{
    /**
     * Returns traversable of color classes/interfaces for which this converter is applicable.
     *
     * @return Traversable<class-string<IConvertableColor>>
     */
    public static function getTargets(): Traversable;

    public function convert(IConvertableColor $color): IConvertableColor;
}
