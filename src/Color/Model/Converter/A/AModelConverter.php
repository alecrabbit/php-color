<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\A;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Exception\InvalidArgument;

abstract readonly class AModelConverter implements IModelConverter
{
    /** @var class-string<IColorDTO> */
    protected string $inputType;

    public function __construct(string $dtoType)
    {
        /** @var class-string<IColorDTO> $dtoType */
        $this->inputType = $dtoType;
    }

    protected function assertColor(IColorDTO $color): void
    {
        if (\is_a($color, $this->inputType, true)) {
            return;
        }

        throw new InvalidArgument(
            \sprintf(
                'Color must be instance of "%s", "%s" given.',
                $this->inputType,
                $color::class,
            ),
        );
    }
}
