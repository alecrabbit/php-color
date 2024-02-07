<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IAHexColor;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\AHex;
use AlecRabbit\Color\Instantiator\AHexInstantiator;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\ModelRGB;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IAHexColor>
 */
final class ToAHexConverter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([AHex::class, IAHexColor::class]);
    }

    public static function getInstantiatorClass(): string
    {
        return AHexInstantiator::class;
    }

    public function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }
}
