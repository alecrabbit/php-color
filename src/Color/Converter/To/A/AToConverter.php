<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\A;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
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
    public function __construct(
        private readonly IRegistry $registry = new Registry(),
    ) {
    }

    abstract public static function getTargets(): Traversable;


    public function convert(IColor $color): IColor
    {
        $dto = $this->partialConvert($color);

        return $this->getInstance($dto);
    }

    public function partialConvert(IColor $color): DColor
    {
        return (new PartialConverter($this->getTargetColorModel(), $this->registry))->convert($color);
    }

    /**
     * // TODO (2024-01-18 16:33) [Alec Rabbit]: make method getTargetColorModel() protected again? [0f579dfe-000a-43f4-82b1-833c7173017d]
     */
    abstract public function getTargetColorModel(): IColorModel;

    abstract protected function getInstance(DColor $dto): IColor;
}
