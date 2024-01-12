<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\To\A\AToConverter;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\ModelHSL;
use ArrayObject;
use Traversable;

/**
 * @extends AToConverter<IHSLAColor>
 */
class ToHSLAConverter extends AToConverter
{
    public static function getTargets(): Traversable
    {
        return new ArrayObject([HSLA::class, IHSLAColor::class]);
    }

    protected function getTargetColorModel(): IColorModel
    {
        return new ModelHSL();
    }

    protected function fromDTO(IColorDTO $dto): IColor
    {
        return HSLA::fromDTO($dto);
    }
}