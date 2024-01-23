<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Builder;

use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;

interface IChainConverterBuilder
{
    /**
     * @param iterable<class-string<IColorModel>> $conversionPath
     */
    public function forPath(iterable $conversionPath): IChainConverterBuilder;

    /**
     * @param iterable<class-string<IModelConverter>> $converters
     */
    public function withConverters(iterable $converters): IChainConverterBuilder;

    public function build(): IChainConverter;
}
