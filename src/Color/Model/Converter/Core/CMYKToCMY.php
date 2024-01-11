<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DCMY as CMY;
use AlecRabbit\Color\Model\DTO\DCMYK as CMYK;

final readonly class CMYKToCMY extends ACoreConverter
{
    protected static function inputType(): string
    {
        return CMYK::class;
    }

    protected function doConvert(IColorDTO $color): IColorDTO
    {
        /** @var CMYK $color */
        return new CMY(
            round($color->cyan * (1 - $color->black) + $color->black, $this->precision),
            round($color->magenta * (1 - $color->black) + $color->black, $this->precision),
            round($color->yellow * (1 - $color->black) + $color->black, $this->precision),
            round($color->alpha, $this->precision),
        );
    }
}
