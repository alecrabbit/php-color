<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\IConvertableColor;

interface IToConverter
{
    /**
     * @return iterable<class-string<IConvertableColor>>
     */
    public static function getTargets(): iterable;

    public function convert(IConvertableColor $color): IConvertableColor;
}
