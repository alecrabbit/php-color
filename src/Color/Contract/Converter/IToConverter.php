<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;

interface IToConverter
{
    /**
     * @return \Traversable<class-string<IConvertableColor>>
     */
    public static function getTargets(): \Traversable;

    public function convert(IConvertableColor $color): IConvertableColor;
}
