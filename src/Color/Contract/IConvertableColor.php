<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Exception\UnimplementedFunctionality;

interface IConvertableColor extends IColor
{
    public static function useConverter(IColorConverter $converter): void;

    public static function useInstantiator(IInstantiator $instantiator): void;

    /**
     * @param class-string $class
     */
    public function to(string $class): IConvertableColor;

    /** @deprecated Will be removed soon. */
    public function toHex(): IConvertableColor;

    /** @deprecated Will be removed soon. */
    public function toHSL(): IConvertableColor;

    /** @deprecated Will be removed soon. */
    public function toHSLA(): IConvertableColor;

    /** @deprecated Will be removed soon. */
    public function toRGB(): IConvertableColor;

    /** @deprecated Will be removed soon. */
    public function toRGBA(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toYUV(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toCMYK(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toXYZ(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toLAB(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toLCh(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toHCL(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toHSV(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toHSVA(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toYIQ(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toGrayscale(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     * @deprecated Will be removed soon.
     */
    public function toPantone(): IConvertableColor;
}
