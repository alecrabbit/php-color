<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\Hex8\From;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHasAlpha;
use AlecRabbit\Color\Contract\IHasBlue;
use AlecRabbit\Color\Contract\IHasGreen;
use AlecRabbit\Color\Contract\IHasRed;
use AlecRabbit\Color\Converter\A\AFromConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex8;

class FromRGBConverter extends AFromConverter
{
    protected static function getSources(): iterable
    {
        return [];
    }

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

    protected static function createColor(IColor $color): IColor
    {
        $alpha = $color instanceof IHasAlpha ? $color->getAlpha() : 0xff;

        /** @var IHasRed&IHasGreen&IHasBlue $color */
        return Hex8::fromRGBA($color->getRed(), $color->getGreen(), $color->getBlue(), $alpha);
    }
}
