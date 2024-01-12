<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\Model\Converter\CMYKToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToCMYKModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\HSLToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToHSLModelConverter;
use AlecRabbit\Color\Model\Converter\Store\ConverterStore;

ConverterStore::add(
    CMYKToCMYModelConverter::class,
    CMYToCMYKModelConverter::class,
    CMYToRGBModelConverter::class,
    HSLToRGBModelConverter::class,
    RGBToCMYModelConverter::class,
    RGBToHSLModelConverter::class,
);
// @codeCoverageIgnoreEnd
