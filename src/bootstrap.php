<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\Converter\To;
use AlecRabbit\Color\Instantiator\Hex8Instantiator;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Color\Instantiator\HSLAInstantiator;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Color\Instantiator\RGBAInstantiator;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\Model\Converter\CMYKToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToCMYKModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\HSLToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToHSLModelConverter;
use AlecRabbit\Color\Package;
use AlecRabbit\Color\Registry\Registry;
use AlecRabbit\Color\Wrapper\Wrapper;

Package::add(
    new Wrapper(
        converter: To\ToHexConverter::class,
        instantiator: HexInstantiator::class,
    ),
    new Wrapper(
        converter: To\ToHex8Converter::class,
        instantiator: Hex8Instantiator::class,
    ),
    new Wrapper(
        converter: To\ToRGBConverter::class,
        instantiator: RGBInstantiator::class,
    ),
    new Wrapper(
        converter: To\ToRGBAConverter::class,
        instantiator: RGBAInstantiator::class,
    ),
    new Wrapper(
        converter: To\ToHSLConverter::class,
        instantiator: HSLInstantiator::class,
    ),
    new Wrapper(
        converter: To\ToHSLAConverter::class,
        instantiator: HSLAInstantiator::class,
    ),
);

Registry::attach(
    CMYKToCMYModelConverter::class,
    CMYToCMYKModelConverter::class,
    CMYToRGBModelConverter::class,
    HSLToRGBModelConverter::class,
    RGBToCMYModelConverter::class,
    RGBToHSLModelConverter::class,
);
// @codeCoverageIgnoreEnd
