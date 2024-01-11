<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To\A;

use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Model\Converter\IColorDTOConverter;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Registry\Registry;
use Traversable;

abstract class AToConverter implements IToConverter
{
    /** @var class-string<IColorDTO> */
    protected string $inputType;

    public function __construct(
        private readonly IRegistry $registry = new Registry(),
        ?string $dtoType = null,
    ) {
        /** @var null|class-string<IColorDTO> $dtoType */
        $this->inputType = $this->refineInputType($dtoType);
    }

    /**
     * @param class-string<IColorDTO>|null $dtoType
     *
     * @return class-string<IColorDTO>
     */
    protected function refineInputType(?string $dtoType): string
    {
        return $dtoType ?? $this->getTargetColorModel()->dtoType();
    }

    abstract protected function getTargetColorModel(): IColorModel;

    /** @inheritDoc */
    abstract public static function getTargets(): Traversable;

    public function convert(IColor $color): IColor
    {
        return $this->fromDTO($this->getModelConverter($color)->convert($color->toDTO()));
    }

    abstract protected function fromDTO(IColorDTO $dto): IColor;

    protected function getModelConverter(IColor $color): IColorDTOConverter
    {
        return $this->registry->getColorConverter(
            from: $color->getColorModel(),
            to: $this->getTargetColorModel(),
        );
    }
}
