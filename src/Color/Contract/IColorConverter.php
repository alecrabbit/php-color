<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IColorConverter
{
    /** @deprecated */
    public function toRGB(IConvertableColor $color): IConvertableColor;

    /** @deprecated */
    public function toRGBA(IConvertableColor $color): IConvertableColor;

    /** @deprecated */
    public function toHex(IConvertableColor $color): IConvertableColor;

    /** @deprecated */
    public function toHSL(IConvertableColor $color): IConvertableColor;

    /** @deprecated */
    public function toHSLA(IConvertableColor $color): IConvertableColor;
}
