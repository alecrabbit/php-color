<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final class RGBToHSLModelConverter implements IModelConverter
{
    public static function to(): IColorModel
    {
        return new ModelHSL();
    }

    public static function from(): IColorModel
    {
        return new ModelRGB();
    }

    public function convert(IColorDTO $color): IColorDTO
    {
        self::assertDTO($color);

        /** @var DRGB $color */
        return (new CoreConverter())->rgbToHsl(
            $color->red,
            $color->green,
            $color->blue,
            $color->alpha,
        );
    }

    protected static function assertDTO(IColorDTO $color): void
    {
        if ($color instanceof DRGB) {
            return;
        }

        throw new InvalidArgument(
            sprintf(
                'Color must be instance of "%s", "%s" given.',
                DRGB::class,
                $color::class,
            ),
        );
    }
}
