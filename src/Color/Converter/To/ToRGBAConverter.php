<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\RGBA;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IRGBAColor>
 */
class ToRGBAConverter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([RGBA::class, IRGBAColor::class]);
    }

    protected function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }

    protected function createColorFromDTO(IColorDTO $dto): IColor
    {
        return RGBA::fromDTO($dto);
    }
}
