<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColorInstantiator
{
    public const REGEXP_HEX = '/^#?(?:([a-f\d]{2}){3}|([a-f\d]){3})$/i';
    public const REGEXP_HSL = '/^hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)$/';
    public const REGEXP_HSLA = '/^hsla?\((\d+),\s*(\d+)%,\s*(\d+)%(?:,\s*([\d.]+))?\)$/';
    public const REGEXP_RGB = '/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/';
    public const REGEXP_RGBA = '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/';

    public function fromString(string $color): IConvertableColor;
}
