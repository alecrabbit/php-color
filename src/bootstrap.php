<?php

declare(strict_types=1);


use AlecRabbit\Color\Converter;
use AlecRabbit\Color\Instantiator;
use AlecRabbit\Color\Parser;
use AlecRabbit\Color\Registry\Registry;
use AlecRabbit\Color\Store\ParserStore;

// @codeCoverageIgnoreStart

Registry::attach(
    Converter\To\ToHexConverter::class,
    Converter\To\ToAHexConverter::class,
    Converter\To\ToHex8Converter::class,
    Converter\To\ToRGBConverter::class,
    Converter\To\ToRGBAConverter::class,
    Converter\To\ToHSLConverter::class,
    Converter\To\ToHSLAConverter::class,
    Instantiator\RGBAInstantiator::class,
    Instantiator\HSLAInstantiator::class,
);

ParserStore::register(Parser\RGBAParser::class);
ParserStore::register(Parser\HEXAParser::class);
ParserStore::register(Parser\HSLAParser::class);
ParserStore::register(Parser\NameParser::class);

// @codeCoverageIgnoreEnd
