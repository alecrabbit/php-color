<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
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
        return new ArrayObject([self::targetColorModel()->dtoType(), RGB::class, IRGBColor::class]);
    }

    protected static function targetColorModel(): IColorModel
    {
        return new ModelRGB();
    }

    protected function createInstance(DColor $dto): IColor
    {
        return RGB::from($dto);
    }
}
