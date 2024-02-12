<?php

declare(strict_types=1);


use AlecRabbit\Color\Converter;
use AlecRabbit\Color\Instantiator;
use AlecRabbit\Color\Parser;
use AlecRabbit\Color\Registry\Registry;

// @codeCoverageIgnoreStart

Registry::attach(
    // Converters
    Converter\To\ToHexConverter::class,
    Converter\To\ToAHexConverter::class,
    Converter\To\ToHex8Converter::class,
    Converter\To\ToRGBConverter::class,
    Converter\To\ToRGBAConverter::class,
    Converter\To\ToHSLConverter::class,
    Converter\To\ToHSLAConverter::class,
    // Instantiators
    Instantiator\RGBAInstantiator::class,
    Instantiator\HSLAInstantiator::class,
    // Parsers
    Parser\RGBAParser::class,
    Parser\HEXAParser::class,
    Parser\HSLAParser::class,
    Parser\NameParser::class,
);

// @codeCoverageIgnoreEnd
