<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\RGBA;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IRGBAColor>
 */
final class ToRGBAConverter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([self::targetColorModel()->dtoType(), RGBA::class, IRGBAColor::class]);
    }

    protected static function targetColorModel(): IColorModel
    {
        return new ModelRGB();
    }

    protected function createInstance(DColor $dto): IColor
    {
        return RGBA::from($dto);
    }
}
