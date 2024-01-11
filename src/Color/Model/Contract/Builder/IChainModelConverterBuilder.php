<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Builder;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\IColorModel;

interface IChainModelConverterBuilder
{
    /**
     * @deprecated
     * @param iterable<class-string<IColorModel>> $conversionPath
     *
     * @return IModelConverter
     */
    public function create(iterable $conversionPath): IModelConverter;

    /**
     * @deprecated
     * @param iterable<class-string<IModelConverter>> $converters
     */
    public function useConverters(iterable $converters): IChainModelConverterBuilder;

    /**
     * @param iterable<class-string<IColorModel>> $conversionPath
     */
    public function forPath(iterable $conversionPath): IChainModelConverterBuilder;

    /**
     * @param iterable<class-string<IModelConverter>> $converters
     */
    public function withConverters(iterable $converters): IChainModelConverterBuilder;

    public function build(): IModelConverter;
}
