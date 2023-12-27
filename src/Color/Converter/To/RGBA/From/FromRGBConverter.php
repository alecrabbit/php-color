<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGBA\From;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IFromConverter;
use AlecRabbit\Color\Contract\IHasBlue;
use AlecRabbit\Color\Contract\IHasGreen;
use AlecRabbit\Color\Contract\IHasRed;
use AlecRabbit\Color\Converter\From\AFromConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\RGBA;

class FromRGBConverter extends AFromConverter implements IFromConverter
{
    public function convert(IConvertableColor $color): IConvertableColor
    {
        self::assertColor($color);
        /** @var IHasRed&IHasGreen&IHasBlue $color */
        return
            self::createColor($color);
    }

    protected static function assertColor(mixed $color): void
    {
        match (true) {
            $color instanceof IHasRed && $color instanceof IHasGreen && $color instanceof IHasBlue => null,
            default => throw new InvalidArgument(
                'Color must be instance of IRGBColor or IHexColor'
            ),
        };
    }

    protected static function createColor(IHasRed&IHasBlue&IHasGreen $c): IConvertableColor
    {
        return RGBA::fromRGBA($c->getRed(), $c->getGreen(), $c->getBlue());
    }
}
