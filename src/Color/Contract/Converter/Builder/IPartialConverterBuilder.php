<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter\Builder;

use AlecRabbit\Color\Contract\Converter\IPartialConverter;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Model\Contract\IColorModel;

interface IPartialConverterBuilder
{
    public function build(): IPartialConverter;

    public function withRegistry(IRegistry $registry): IPartialConverterBuilder;

    public function withColorModel(IColorModel $colorModel): IPartialConverterBuilder;
}
