<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Factory;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;

interface IModelConverterFactory
{
    public function create(iterable $conversionPath): IModelConverter;

    public function useConverters(iterable $converters): IModelConverterFactory;
}
