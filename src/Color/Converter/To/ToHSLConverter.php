<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\ModelHSL;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IHSLColor>
 */
final class ToHSLConverter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([HSL::class, IHSLColor::class]);
    }

    public static function getInstantiatorClass(): string
    {
        return HSLInstantiator::class;
    }

    protected function getTargetColorModel(): IColorModel
    {
        return new ModelHSL();
    }
}
