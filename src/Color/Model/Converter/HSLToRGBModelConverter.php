<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILegacyCoreConverter;
use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\Dummy;
use AlecRabbit\Color\Model\Converter\Core\HSLToRGB;
use AlecRabbit\Color\Model\Converter\Core\LegacyCoreConverter;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final readonly class HSLToRGBModelConverter extends AModelConverter
{
    protected static function getFromModelClass(): string
    {
        return ModelHSL::class;
    }

    protected static function getToModelClass(): string
    {
        return ModelRGB::class;
    }

    protected static function getConverterClass(): string
    {
        return HSLToRGB::class;
    }
}
