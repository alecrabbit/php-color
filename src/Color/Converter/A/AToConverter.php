<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\A;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverterRegistry;
use AlecRabbit\Color\Contract\IFromConverter;
use AlecRabbit\Color\Contract\IToConverter;
use AlecRabbit\Color\Converter\Registry\ConverterRegistry;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;

abstract class AToConverter implements IToConverter
{
    public function __construct(
        private readonly IConverterRegistry $registry = new ConverterRegistry(),
    ) {
    }

    public function convert(IConvertableColor $color): IConvertableColor
    {
        return $this->getConverter($color)->convert($color);
    }

    /**
     * @throws UnsupportedColorConversion
     */
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

    protected function getConverter(IConvertableColor $color): IFromConverter
    {
        return $this->registry->getFromConverter($this::class, $color::class) ?? $this->unsupportedConversion($color);
    }

    /**
     * @return class-string<IConvertableColor>
     */
    abstract protected static function getTargetClass(): string;
}
