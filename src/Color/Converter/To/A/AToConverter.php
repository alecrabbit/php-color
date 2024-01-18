<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\A;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Converter\To\PartialConverter;
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

    /**
     * // TODO (2024-01-18 16:33) [Alec Rabbit]: make protected again [0f579dfe-000a-43f4-82b1-833c7173017d]
     */
    abstract public function getTargetColorModel(): IColorModel;

    abstract public static function getTargets(): Traversable;

    public function convert(IColor $color): IColor
    {
        /** @var class-string<IInstantiator<T>> $instantiatorClass */
        $instantiatorClass = static::getInstantiatorClass();

        return (new $instantiatorClass())->from($this->partialConvert($color));
    }

    abstract public static function getInstantiatorClass(): string;

    public function partialConvert(IColor $color): DColor
    {
        return (new PartialConverter($this->getTargetColorModel(), $this->registry))->convert($color);
    }
}
