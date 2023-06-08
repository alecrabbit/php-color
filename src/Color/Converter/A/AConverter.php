<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\A;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;

abstract class AConverter implements IConverter
{
    abstract public function convert(IConvertableColor $color): IConvertableColor;

    protected function unsupportedConversion(IConvertableColor $color): never
    {
        throw new UnsupportedColorConversion(
            sprintf(
                'Conversion from "%s" to "%s" is not supported by "%s".',
                $color::class,
                $this->getTargetClass(),
                static::class
            )
        );
    }

    /**
     * @return class-string
     */
    abstract protected function getTargetClass(): string;
}
