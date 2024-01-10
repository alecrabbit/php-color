<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSL;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\ModelHSL;
use ArrayObject;
use Traversable;

class ToHSLConverter extends AToConverter
{
    /** @inheritDoc */
    public static function getTargets(): Traversable
    {
        return new ArrayObject([HSL::class, IHSLColor::class]);
    }

    private static function assertDTO(IColorDTO $dto): void
    {
        if ($dto instanceof DHSL) {
            return;
        }

        throw new InvalidArgument(
            sprintf(
                'Color must be instance of "%s", "%s" given.',
                DHSL::class,
                $dto::class,
            ),
        );
    }

    protected function getTargetColorModel(): IColorModel
    {
        return new ModelHSL();
    }

    protected function fromDTO(IColorDTO $dto): IColor
    {
        /** @var DHSL $dto */
        return HSL::fromHSL(
            $dto->hue,
            $dto->saturation,
            $dto->lightness,
        );
    }
}
