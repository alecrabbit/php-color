<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\ModelRGB;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IHexColor>
 */
final class ToHexConverter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([Hex::class, IHexColor::class]);
    }

    public static function getInstantiatorClass(): string
    {
        return HexInstantiator::class;
    }

    public function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }
}
