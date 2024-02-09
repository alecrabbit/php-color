<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\To;

use AlecRabbit\Color\Contract\Converter\IPartialConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Model\Contract\Converter\IConverter;
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
            ->convert($color->dto());
    }


    private function getModelConverter(IColorModel $from): IConverter
    {
        return $this->registry->getModelConverter(
            from: $from,
            to: $this->targetColorModel,
        );
    }
}
