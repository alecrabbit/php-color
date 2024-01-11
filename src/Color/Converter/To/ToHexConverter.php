<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Model\ModelRGB;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IHexColor>
 */
class ToHexConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): Traversable
    {
        return new ArrayObject([Hex::class, IHexColor::class]);
    }


    protected function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }

    protected function fromDTO(IColorDTO $dto): IColor
    {
        return Hex::fromDTO($dto);
    }
}
