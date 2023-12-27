<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\A;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IToConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;

abstract class AToConverter implements IToConverter
{
    abstract public function convert(IConvertableColor $color): IConvertableColor;

    protected function unsupportedConversion(object $from, ?string $to = null): never
    {
        throw new UnsupportedColorConversion(
            sprintf(
                'Conversion from "%s" to "%s" is not supported by "%s".',
                $from::class,
                $to ?? static::getTargetClass(),
                static::class
            )
        );
    }

    /**
     * @deprecated pass class-string<IConvertableColor> to `unsupportedConversion` as a parameter instead
     * @return class-string<IConvertableColor>
     */
    abstract protected static function getTargetClass(): string;
}
