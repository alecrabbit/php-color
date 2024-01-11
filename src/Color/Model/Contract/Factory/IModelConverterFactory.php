<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Factory;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\IColorModel;

interface IModelConverterFactory
{
    /**
     * @param iterable<class-string<IColorModel>> $conversionPath
     *
     * @return IModelConverter
     */
    public function create(iterable $conversionPath): IModelConverter;

    /**
     * @param iterable<class-string<IModelConverter>> $converters
     */
    public function useConverters(iterable $converters): IModelConverterFactory;
}
