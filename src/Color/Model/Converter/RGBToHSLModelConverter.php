<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILegacyCoreConverter;
use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\Dummy;
use AlecRabbit\Color\Model\Converter\Core\LegacyCoreConverter;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final readonly class RGBToHSLModelConverter extends AModelConverter
{
    public function __construct(
        private ILegacyCoreConverter $legacyConverter = new LegacyCoreConverter(),
    ) {
        parent::__construct();
    }

    protected static function getFromModelClass(): string
    {
        return ModelRGB::class;
    }

    protected static function getToModelClass(): string
    {
        return ModelHSL::class;
    }

    protected static function getConverterClass(): string
    {
        return Dummy::class;
    }

    public function convert(IColorDTO $color): IColorDTO
    {
        $this->assertColor($color);

        /** @var DRGB $color */
        return $this->legacyConverter
            ->rgbToHsl(
                $color->red,
                $color->green,
                $color->blue,
                $color->alpha,
            );
    }
}
