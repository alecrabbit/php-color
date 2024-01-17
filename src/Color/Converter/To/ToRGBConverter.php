<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\RGB;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IRGBColor>
 */
final class ToRGBConverter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([RGB::class, IRGBColor::class]);
    }

    public static function getInstantiatorClass(): string
    {
        return RGBInstantiator::class;
    }

    protected function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }
}
