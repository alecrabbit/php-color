<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHex8Color;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\Model\ModelRGB;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IHex8Color>
 */
class ToHex8Converter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([Hex8::class, IHex8Color::class]);
    }


    protected function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }

    protected function fromDTO(IColorDTO $dto): IColor
    {
        return Hex8::fromDTO($dto);
    }
}
