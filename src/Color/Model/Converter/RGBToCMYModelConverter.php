<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\Dummy;
use AlecRabbit\Color\Model\ModelCMY;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final readonly class RGBToCMYModelConverter extends AModelConverter
{
    protected static function getFromModelClass(): string
    {
        return ModelRGB::class;
    }

    protected static function getToModelClass(): string
    {
        return ModelCMY::class;
    }

    protected static function getConverterClass(): string
    {
        return Dummy::class;
    }

}
