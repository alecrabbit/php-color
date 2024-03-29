<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IHex8Color;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\Instantiator\Hex8Instantiator;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\ModelRGB;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IHex8Color>
 */
final class ToHex8Converter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([Hex8::class, IHex8Color::class]);
    }

    public static function getInstantiatorClass(): string
    {
        return Hex8Instantiator::class;
    }

    public function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }
}
