<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter;

use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Factory\ConverterFactory;

class ColorConverter implements IColorConverter
{
    public function __construct(
        protected IConverterFactory $converterFactory = new ConverterFactory()
    ) {
    }

    /** @inheritDoc */
    public function to(string $class): IConverter
    {
        return $this->converterFactory->make($class);
    }
}
