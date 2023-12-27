<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGBA\From;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHasBlue;
use AlecRabbit\Color\Contract\IHasGreen;
use AlecRabbit\Color\Contract\IHasRed;
use AlecRabbit\Color\Converter\A\AFromConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\RGBA;

class FromRGBConverter extends AFromConverter
{
    protected static function assertColor(mixed $color): void
    {
        match (true) {
            $color instanceof IHasRed && $color instanceof IHasGreen && $color instanceof IHasBlue => null,
            default => throw new InvalidArgument(
                sprintf(
                    'Unsupported color type "%s".',
                    $color::class
                )
            ),
        };
    }

    protected static function createColor(IConvertableColor $color): IConvertableColor
    {
        /** @var IHasRed&IHasGreen&IHasBlue $color */
        return RGBA::fromRGBA($color->getRed(), $color->getGreen(), $color->getBlue());
    }
}