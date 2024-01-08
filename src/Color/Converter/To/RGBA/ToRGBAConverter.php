<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGBA;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\RGBA;
use ArrayObject;
use Traversable;

class ToRGBAConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): Traversable
    {
        return new ArrayObject([RGBA::class, IRGBAColor::class]);
    }

    protected function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }

    protected function fromDTO(IColorDTO $dto): IColor
    {
        $this->assertColor($dto);

        /** @var DRGB $dto */
        return RGBA::fromRGBO(
            $dto->red,
            $dto->green,
            $dto->blue,
            $dto->alpha,
        );
    }
}
