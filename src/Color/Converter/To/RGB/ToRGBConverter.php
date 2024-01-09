<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\RGB;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\RGB;
use ArrayObject;
use Traversable;

class ToRGBConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): Traversable
    {
        return new ArrayObject([RGB::class, IRGBColor::class]);
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
        return RGB::fromRGB(
            $dto->red,
            $dto->green,
            $dto->blue,
        );
    }
}
