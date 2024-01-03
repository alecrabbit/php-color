<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\A;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Registry\Registry;
use Traversable;

abstract class AToConverter implements IToConverter
{
    public function __construct(
        private readonly IRegistry $registry = new Registry(),
    ) {
    }

    /** @inheritDoc */
    abstract public static function getTargets(): Traversable;

    public function convert(IConvertableColor $color): IConvertableColor
    {
        return $this->getFromConverter($color)->convert($color);
    }

    protected function getFromConverter(IConvertableColor $source): IFromConverter
    {
        return
            $this->registry->getFromConverter($this::class, $source::class)
            ??
            throw new UnsupportedColorConversion(
                sprintf(
                    'Conversion from "%s" is not supported by "%s".',
                    $source::class,
                    static::class
                )
            );
    }
}
