<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\A;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Model\Contract\Converter\IDColorConverter;
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
    /** @var class-string<DColor> */
    protected string $inputType;

    public function __construct(
        private readonly IRegistry $registry = new Registry(),
        ?string $dtoType = null,
    ) {
        /** @var null|class-string<DColor> $dtoType */
        $this->inputType = $this->refineInputType($dtoType);
    }

    /**
     * @param class-string<DColor>|null $dtoType
     *
     * @return class-string<DColor>
     */
    protected function refineInputType(?string $dtoType): string
    {
        return $dtoType ?? $this->getTargetColorModel()->dtoType();
    }

    abstract protected function getTargetColorModel(): IColorModel;

    abstract public static function getTargets(): Traversable;

    public function convert(IColor $color): IColor|DColor
    {
        /** @var class-string<IInstantiator<T>> $instantiatorClass */
        $instantiatorClass = static::getInstantiatorClass();
        return (new $instantiatorClass())->from($this->convertToTargetDTO($color));
    }

    abstract public static function getInstantiatorClass(): string;

    protected function convertToTargetDTO(IColor $color): DColor
    {
        return $this->getModelConverter($color)->convert($color->toDTO());
    }

    protected function getModelConverter(IColor $color): IDColorConverter
    {
        return $this->registry->getColorConverter(
            from: $color->getColorModel(),
            to: $this->getTargetColorModel(),
        );
    }
}
