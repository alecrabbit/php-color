<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\Hex;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;
use ArrayObject;
use Traversable;

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
        $this->assertColor($dto);

        /** @var DRGB $dto */
        return Hex::fromRGB(
            $dto->red,
            $dto->green,
            $dto->blue,
        );
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
}
