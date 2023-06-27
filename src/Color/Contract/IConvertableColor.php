<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IConvertableColor extends IColor
{
    public static function useConverter(IColorConverter $converter): void;

    public static function useInstantiator(IInstantiator $instantiator): void;

    /**
     * @param class-string $class
     */
    public function to(string $class): IConvertableColor;
}
