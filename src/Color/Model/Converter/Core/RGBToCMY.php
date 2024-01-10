<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DCMY as CMY;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;

final readonly class RGBToCMY extends ACoreConverter
{
    protected static function inputType(): string
    {
        return RGB::class;
    }

    protected function doConvert(IColorDTO $color): IColorDTO
    {
        /** @var RGB $color */


        return new CMY();
    }
}
