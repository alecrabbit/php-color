<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\ColorException;

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
    protected static ?IInstantiator $instantiator = null;
    protected static ?IColorConverter $converter = null;

    final public static function useConverter(IColorConverter $converter): void
    {
        self::$converter = $converter;
    }

    final public static function useInstantiator(IInstantiator $instantiator): void
    {
        self::$instantiator = $instantiator;
    }

    public static function fromString(string $color): IConvertableColor
    {
        return self::getInstantiator()->fromString($color);
    }

    protected static function getInstantiator(): IInstantiator
    {
        if (null === self::$instantiator) {
            throw new ColorException('Instantiator is not set.');
        }
        return self::$instantiator;
    }

    public function to(string $class): IConvertableColor
    {
        return self::getConverter()->to($class)->convert($this);
    }

    protected static function getConverter(): IColorConverter
    {
        if (null === self::$converter) {
            throw new ColorException('Converter is not set.');
        }
        return self::$converter;
    }


    abstract public function toString(): string;
}
