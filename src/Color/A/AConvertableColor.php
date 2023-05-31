<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\ColorConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use RuntimeException;

abstract class AConvertableColor implements IConvertableColor
{
    protected readonly IColorConverter $converter;

    public function __construct(
        ?IColorConverter $converter = null,
    ) {
        $this->converter = $converter ?? new ColorConverter();
    }

    public static function fromString(string $color): IColor
    {
        // TODO: Implement fromString() method.
        throw new RuntimeException('Not implemented.');
    }

    public function toHex(): IConvertableColor
    {
        // TODO: Implement toHex()  method.
        throw new RuntimeException('Not implemented.');
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
        return $this->converter->toRGB($this);
    }

    public function toRGBA(): IConvertableColor
    {
        return $this->converter->toRGBA($this);
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
