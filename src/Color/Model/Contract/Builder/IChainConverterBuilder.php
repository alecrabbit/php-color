<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Builder;

use AlecRabbit\Color\Contract\Model\Converter\IColorDTOConverter;
use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\IColorModel;

interface IChainConverterBuilder
{
    /**
     * @deprecated
     * @param iterable<class-string<IColorModel>> $conversionPath
     *
     * @return IColorDTOConverter
     */
    public function create(iterable $conversionPath): IColorDTOConverter;

    /**
     * @deprecated
     * @param iterable<class-string<IModelConverter>> $converters
     */
    public function useConverters(iterable $converters): IChainConverterBuilder;

    /**
     * @param iterable<class-string<IColorModel>> $conversionPath
     */
    public function forPath(iterable $conversionPath): IChainConverterBuilder;

    /**
     * @param iterable<class-string<IModelConverter>> $converters
     */
    public function withConverters(iterable $converters): IChainConverterBuilder;

    public function build(): IColorDTOConverter;
}
