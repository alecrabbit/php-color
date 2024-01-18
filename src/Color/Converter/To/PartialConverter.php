<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\Converter\IPartialConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Model\Contract\Converter\IDColorConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;

final readonly class PartialConverter implements IPartialConverter
{
    public function __construct(
        private IColorModel $targetColorModel,
        private IRegistry $registry,
    ) {
    }

    public function convert(IColor $color): DColor
    {
        $sourceColorModel = $color->getColorModel();

        return $this->getModelConverter($sourceColorModel)
            ->convert($color->to($sourceColorModel->dtoType()));
    }


    private function getModelConverter(IColorModel $from): IDColorConverter
    {
        return $this->registry->getColorConverter(
            from: $from,
            to: $this->targetColorModel,
        );
    }
}
