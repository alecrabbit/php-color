<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\ModelRGB;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IHexColor>
 */
class ToHexConverter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([Hex::class, IHexColor::class]);
    }


    protected function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }

    protected function createColorFromDTO(IColorDTO $dto): IColor
    {
        return Hex::fromDTO($dto);
    }
}
