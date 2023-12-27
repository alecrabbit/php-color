<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGBA;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverterRegistry;
use AlecRabbit\Color\Contract\IFromConverter;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Converter\Registry\ConverterRegistry;

class ToRGBAConverter extends AToConverter
{
    public function __construct(
        private readonly IConverterRegistry $registry = new ConverterRegistry(),
    )
    {
//        $this->converters = new \ArrayObject(
//            [
//                IRGBAColor::class => $noOp = new NoOpConverter(),
//                RGBA::class => $noOp,
//                IRGBColor::class => $fromRGBConverter = new FromRGBConverter(),
//                RGB::class => $fromRGBConverter,
//                IHexColor::class => $fromRGBConverter,
//                Hex::class => $fromRGBConverter,
//
//            ]
//        );
    }

    /** @inheritDoc */
    protected static function getTargetClass(): string
    {
        throw new \RuntimeException('Deprecated method. Should not be called.');
    }

    public function convert(IConvertableColor $color): IConvertableColor
    {
        return $this->getConverter($color)->convert($color);
    }

    private function getConverter(IConvertableColor $color): IFromConverter
    {
        return $this->registry->getFromConverter($this::class, $color::class) ?? $this->unsupportedConversion($color, IRGBAColor::class);
//        return $this->converters[$color::class] ?? $this->unsupportedConversion($color, IRGBAColor::class);
    }
}
