<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;

final class HSLToRGBModelConverter implements IModelConverter
{
    public static function to(): IColorModel
    {
        return new ModelRGB();
    }

    public static function from(): IColorModel
    {
        return new ModelHSL();
    }

    public function convert(IColorDTO $color): IColorDTO
    {
        self::assertDTO($color);

        /** @var DHSL $color */
        return (new CoreConverter())->hslToRgb(
            $color->hue,
            $color->saturation,
            $color->lightness,
            $color->alpha,
        );
    }

    protected static function assertDTO(IColorDTO $color): void
    {
        if ($color instanceof DHSL) {
            return;
        }

        throw new InvalidArgument(
            sprintf(
                'Color must be instance of "%s", "%s" given.',
                DHSL::class,
                $color::class,
            ),
        );
    }
}
