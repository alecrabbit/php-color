<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Exception\UnimplementedFunctionality;

interface IConvertableColor extends IColor
{
    public static function useConverter(IColorConverter $converter): void;

    public static function useInstantiator(IColorInstantiator $instantiator): void;

    public function toHex(): IConvertableColor;

    public function toHSL(): IConvertableColor;

    public function toHSLA(): IConvertableColor;

    public function toRGB(): IConvertableColor;

    public function toRGBA(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toYUV(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toCMYK(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toXYZ(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toLAB(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toLCh(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toHCL(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toHSV(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toHSVA(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toYIQ(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toGrayscale(): IConvertableColor;

    /**
     * @throws UnimplementedFunctionality
     */
    public function toPantone(): IConvertableColor;
}
