<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IConvertableColor extends IColor
{
    /**
     * @param class-string<IConvertableColor> $class
     */
    public function to(string $class): IConvertableColor;

    public static function from(IConvertableColor $color): IConvertableColor;
}
