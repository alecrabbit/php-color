<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\Converter\ToHexConverter;
use AlecRabbit\Color\Converter\ToHSLAConverter;
use AlecRabbit\Color\Converter\ToHSLConverter;
use AlecRabbit\Color\Converter\ToRGBAConverter;
use AlecRabbit\Color\Converter\ToRGBConverter;
use AlecRabbit\Color\Factory\ConverterFactory;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

ConverterFactory::registerConverter(RGB::class, ToRGBConverter::class);
ConverterFactory::registerConverter(RGBA::class, ToRGBAConverter::class);
ConverterFactory::registerConverter(Hex::class, ToHexConverter::class);
ConverterFactory::registerConverter(HSL::class, ToHSLConverter::class);
ConverterFactory::registerConverter(HSLA::class, ToHSLAConverter::class);

// @codeCoverageIgnoreEnd
