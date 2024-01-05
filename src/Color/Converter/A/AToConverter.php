<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\A;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
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

    protected function fromDTO(IColorDTO $dto): IColor
    {
    }

//    /**
//     * @throws UnsupportedColorConversion
//     */
///   public function convert(IColor $color): IColor
//    {
//        return $this->fromDTO($this->registry->getModelConverter(
//            from: $color->getColorModel(),
//            to: $this->getColorModel(),
//        )
//            ->convert($color->toDTO()));
//    }

    public function convert(IColor $color): IColor
    {
        return $this->getFromConverter($color)->convert($color);
    }

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

    protected function getColorModel(): IColorModel
    {

    }

}
