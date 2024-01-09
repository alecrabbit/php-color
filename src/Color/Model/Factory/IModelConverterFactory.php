<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Factory;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;

interface IModelConverterFactory
{
    public function create(iterable $converterPath): IModelConverter;

    public function useConverters(iterable $converters): IModelConverterFactory;
}
