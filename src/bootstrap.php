<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Converter\ToHex\ToHexConverter;
use AlecRabbit\Color\Converter\ToHSL\ToHSLAConverter;
use AlecRabbit\Color\Converter\ToHSL\ToHSLConverter;
use AlecRabbit\Color\Converter\ToRGB\ToRGBAConverter;
use AlecRabbit\Color\Converter\ToRGB\ToRGBConverter;
use AlecRabbit\Color\Factory\ConverterFactory;
use AlecRabbit\Color\Factory\InstantiatorFactory;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;

// FIXME (2023-12-21 19:6) [Alec Rabbit]: rethink registration process, make it more flexible and simple

ConverterFactory::register(RGB::class, ToRGBConverter::class);
ConverterFactory::register(RGBA::class, ToRGBAConverter::class);
ConverterFactory::register(IRGBAColor::class, ToRGBAConverter::class);
ConverterFactory::register(Hex::class, ToHexConverter::class);
ConverterFactory::register(IHexColor::class, ToHexConverter::class);
ConverterFactory::register(HSL::class, ToHSLConverter::class);
ConverterFactory::register(HSLA::class, ToHSLAConverter::class);

// Order is important
InstantiatorFactory::register(HexInstantiator::class);
InstantiatorFactory::register(RGBInstantiator::class);
InstantiatorFactory::register(HSLInstantiator::class);

// @codeCoverageIgnoreEnd
