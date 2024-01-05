<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\HSLA;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\A\AToConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\ModelHSL;
use ArrayObject;
use Traversable;

class ToHSLAConverter extends AToConverter
{
    /** @inheritDoc */
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
        self::assertDTO($dto);

        /** @var DHSL $dto */
        return HSLA::fromHSLA(
            $dto->hue,
            $dto->saturation,
            $dto->lightness,
            $dto->alpha,
        );
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
}
