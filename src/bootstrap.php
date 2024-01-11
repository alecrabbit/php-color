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
        instantiator: HexInstantiator::class,
        converter: To\ToHexConverter::class,
    ),
    new Wrapper(
        instantiator: Hex8Instantiator::class,
        converter: To\ToHex8Converter::class,
    ),
    new Wrapper(
        instantiator: RGBInstantiator::class,
        converter: To\ToRGBConverter::class,
    ),
    new Wrapper(
        instantiator: RGBAInstantiator::class,
        converter: To\ToRGBAConverter::class,
    ),
    new Wrapper(
        instantiator: HSLInstantiator::class,
        converter: To\ToHSLConverter::class,
    ),
    new Wrapper(
        instantiator: HSLAInstantiator::class,
        converter: To\ToHSLAConverter::class,
    ),
);

Registry::attach(
    HSLToRGBModelConverter::class,
    RGBToHSLModelConverter::class,
    RGBToCMYModelConverter::class,
    CMYToCMYKModelConverter::class,
    CMYKToCMYModelConverter::class,
    CMYToRGBModelConverter::class,
);
// @codeCoverageIgnoreEnd
