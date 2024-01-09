<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILegacyCoreConverter;
use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\Dummy;
use AlecRabbit\Color\Model\Converter\Core\HSLtoRGB;
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
        return HSLtoRGB::class;
    }

    public function convert(IColorDTO $color): IColorDTO
    {
        // TODO (2024-01-09 14:20) [Alec Rabbit]: remove this method and fix tests
        $this->assertColor($color);

        return $this->converter->convert($color);
    }
}
