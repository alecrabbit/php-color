<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\Hex8;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHex8Color;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;
use ArrayObject;
use Traversable;

class ToHex8Converter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): Traversable
    {
        return new ArrayObject([Hex8::class, IHex8Color::class]);
    }

    private static function assertDTO(IColorDTO $dto): void
    {
        if ($dto instanceof DRGB) {
            return;
        }

        throw new InvalidArgument(
            sprintf(
                'Color must be instance of "%s", "%s" given.',
                DRGB::class,
                $dto::class,
            ),
        );
    }

    protected function getTargetColorModel(): IColorModel
    {
        return new ModelRGB();
    }

    protected function fromDTO(IColorDTO $dto): IColor
    {
        $this->assertColor($dto);

        /** @var DRGB $dto */
        return Hex8::fromRGBO(
            $dto->red,
            $dto->green,
            $dto->blue,
            $dto->alpha,
        );
    }
}
