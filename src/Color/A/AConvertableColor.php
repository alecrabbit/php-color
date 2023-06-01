<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\ColorConverter;
use AlecRabbit\Color\ColorInstantiator;
use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IColorInstantiator;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Exception\ColorException;
use RuntimeException;

abstract class AConvertableColor implements IConvertableColor
{
    protected static ?IColorInstantiator $instantiator = null;
    protected static ?IColorConverter $converter = null;

    final public static function useConverter(IColorConverter $converter): void
    {
        self::$converter = $converter;
    }

    final public static function useInstantiator(IColorInstantiator $instantiator): void
    {
        self::$instantiator = $instantiator;
    }

    public static function fromString(string $color): IConvertableColor
    {
        return self::getInstantiator()->fromString($color);
    }

    protected static function getInstantiator(): IColorInstantiator
    {
        if (null === self::$instantiator) {
            throw new ColorException('Instantiator is not set.');
        }
        return self::$instantiator;
    }

    protected static function getConverter(): IColorConverter
    {
        if (null === self::$converter) {
            throw new ColorException('Converter is not set.');
        }
        return self::$converter;
    }

    public function toHex(): IConvertableColor
    {
        return self::getConverter()->toHex($this);
    }

    public function toHSL(): IConvertableColor
    {
        // TODO: Implement toHSL()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toHSLA(): IConvertableColor
    {
        // TODO: Implement toHSLA()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toRGB(): IConvertableColor
    {
        return self::getConverter()->toRGB($this);
    }

    public function toRGBA(): IConvertableColor
    {
        return self::getConverter()->toRGBA($this);
    }

    public function toYUV(): IConvertableColor
    {
        // TODO: Implement toYUV()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toCMYK(): IConvertableColor
    {
        // TODO: Implement toCMYK()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toXYZ(): IConvertableColor
    {
        // TODO: Implement toXYZ()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toLAB(): IConvertableColor
    {
        // TODO: Implement toLAB()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toLCh(): IConvertableColor
    {
        // TODO: Implement toLCh()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toHCL(): IConvertableColor
    {
        // TODO: Implement toHCL()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toHSV(): IConvertableColor
    {
        // TODO: Implement toHSV()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toHSVA(): IConvertableColor
    {
        // TODO: Implement toHSVA()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toYIQ(): IConvertableColor
    {
        // TODO: Implement toYIQ()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toGrayscale(): IConvertableColor
    {
        // TODO: Implement toGrayscale()  method.
        throw new RuntimeException('Not implemented.');
    }

    public function toPantone(): IConvertableColor
    {
        // TODO: Implement toPantone()  method.
        throw new RuntimeException('Not implemented.');
    }

    abstract public function toString(): string;
}
