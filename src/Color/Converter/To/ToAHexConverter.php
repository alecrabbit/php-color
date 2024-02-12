<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\AHex;
use AlecRabbit\Color\Contract\IAHexColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
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
        return new ArrayObject([self::targetColorModel()->dtoType(), AHex::class, IAHexColor::class]);
    }

    protected static function targetColorModel(): IColorModel
    {
        return new ModelRGB();
    }

    /** @inheritDoc */
    protected function createInstance(DColor $dto): IColor
    {
        return AHex::from($dto);
    }
}
