<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\A;

use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Model\ModelRGB;

abstract class AFromRGBConverter extends AFromConverter
{
    public static function getColorModel(): IColorModel
    {
        return new ModelRGB();
    }
}
