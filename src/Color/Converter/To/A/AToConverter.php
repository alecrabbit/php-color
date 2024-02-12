<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\A;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Registry\Registry;
use Traversable;

/**
 * @template-covariant T of IColor
 *
 * @implements IToConverter<T>
 */
abstract class AToConverter implements IToConverter
{
    public function __construct(
        private readonly IRegistry $registry = new Registry(),
    ) {
    }

    abstract public static function getTargets(): Traversable;


    public function convert(IColor $color): IColor
    {
        $modelConverter = $this->registry->getModelConverter(
            $color->getColorModel(),
            $this->getTargetColorModel()
        );

        $dto = $modelConverter->convert($color->dto());

        return $this->createInstance($dto);
    }

    protected function getTargetColorModel(): IColorModel
    {
        return static::targetColorModel();
    }

    /**
     * @psalm-return T
     */
    abstract protected function createInstance(DColor $dto): IColor;
}
