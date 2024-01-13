<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DCMY as CMY;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;

final readonly class RGBToCMY extends ACoreConverter
{
    protected static function inputType(): string
    {
        return RGB::class;
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var RGB $color */
        return new CMY(
            round(1 - $color->red / 255, $this->precision),
            round(1 - $color->green / 255, $this->precision),
            round(1 - $color->blue / 255, $this->precision),
            round($color->alpha, $this->precision),
        );
    }
}
