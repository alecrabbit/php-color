<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\Hex8\From;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHasAlpha;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\A\AFromConverter;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\Model\HSL\ModelHSL;

class FromHSLConverter extends AFromConverter
{
    public static function getColorModel(): IColorModel
    {
        return new ModelHSL();
    }

    protected static function assertColor(mixed $color): void
    {
        match (true) {
            $color instanceof IHSLColor => null,
            default => throw new InvalidArgument(
                sprintf(
                    'Unsupported color type "%s".',
                    $color::class
                )
            ),
        };
    }

    protected static function createColor(IColor $color): IColor
    {
        /** @var IHSLColor $color */
        $rgb = (new CoreConverter())->hslToRgb(
            $color->getHue(),
            $color->getSaturation(),
            $color->getLightness()
        );

        $alpha = $color instanceof IHasAlpha ? $color->getAlpha() : 0xff;

        return
            Hex8::fromRGBA($rgb->red, $rgb->green, $rgb->blue, $alpha);
    }
}
