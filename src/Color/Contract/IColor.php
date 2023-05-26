<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColor
{
    public const FORMAT_HEX = '#%02x%02x%02x';
    public const FORMAT_HSL = 'hsl(%d, %s%%, %s%%)';
    public const FORMAT_HSLA = 'hsla(%d, %s%%, %s%%, %s)';
    public const FORMAT_RGB = 'rgb(%d, %d, %d)';
    public const FORMAT_RGBA = 'rgba(%d, %d, %d, %s)';

    public function fromString(string $color): IColor;

    public function toString(): string;
}
