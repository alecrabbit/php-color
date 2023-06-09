<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IColorInstantiator;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Exception\ColorException;
use AlecRabbit\Color\Exception\UnimplementedFunctionality;

/**
 * This class provides various functionalities related to color conversion.
 * It contains several methods, some of which may not be implemented yet.
 * Thees methods are serving as a placeholder for potential future functionality or as a reference for extension.
 * Unimplemented methods throw `UnimplementedFunctionality` exception.
 * Please refer to the package documentation for updates on method availability.
 *
 * @link https://github.com/alecrabbit/php-color
 */
abstract class AConvertableColor implements IConvertableColor
{
    protected const COMPONENT = 0xFF;
    private const K_METHOD_NOT_IMPLEMENTED = 'Method is not implemented yet. ["%s"]';
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

    public function toHex(): IConvertableColor
    {
        return self::getConverter()->toHex($this);
    }

    protected static function getConverter(): IColorConverter
    {
        if (null === self::$converter) {
            throw new ColorException('Converter is not set.');
        }
        return self::$converter;
    }

    public function toHSL(): IConvertableColor
    {
        return self::getConverter()->toHSL($this);
    }

    public function toHSLA(): IConvertableColor
    {
        return self::getConverter()->toHSLA($this);
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
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toCMYK(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toXYZ(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toLAB(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toLCh(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toHCL(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toHSV(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toHSVA(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toYIQ(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toGrayscale(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    public function toPantone(): IConvertableColor
    {
        // Implementation may or may NOT be added in the future.
        throw new UnimplementedFunctionality(
            sprintf(self::K_METHOD_NOT_IMPLEMENTED, __METHOD__)
        );
    }

    abstract public function toString(): string;
}
