<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\A;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
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

    public function convert(IColor $color): IColor
    {
        return $this->getFromConverter($color)->convert($color);
    }

//    public function convert(IColor $color): IColor
//    {
//        return $this->fromDTO(
//            $this->getModelConverter(
//                from: $color->getColorModel(),
//                to: $this->getColorModel()
//            )
//                ->toDTO($color)
//        );
//    }
//
//    /**
//     * @throws UnsupportedColorConversion
//     */
//    protected function getFromConverter(IColorModel $from, IColorModel $to): IFromConverter
//    {
//        return
//            $this->registry->getModelConverter($from, $to)
//    }

    protected function getFromConverter(IColor $source): IFromConverter
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
