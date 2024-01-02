<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\From\NoOpConverter;
use AlecRabbit\Color\Converter\To;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Color\Instantiator\HSLAInstantiator;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Color\Instantiator\RGBAInstantiator;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\Package;
use AlecRabbit\Color\Registry\Registry;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Wrapper\Wrapper;

Package::add(
    new Wrapper(
        to: new ArrayObject([Hex::class, IHexColor::class]),
        from: new ArrayObject(),
        converter: To\Hex\ToHexConverter::class,
        instantiator: HexInstantiator::class,
    ),
    new Wrapper(
        to: new ArrayObject([RGB::class, IRGBColor::class]),
        from: new ArrayObject(),
        converter: To\RGB\ToRGBConverter::class,
        instantiator: RGBInstantiator::class,
    ),
    new Wrapper(
        to: new ArrayObject([RGBA::class, IRGBAColor::class]),
        from: new ArrayObject(),
        converter: To\RGBA\ToRGBAConverter::class,
        instantiator: RGBAInstantiator::class,
    ),
    new Wrapper(
        to: new ArrayObject([HSL::class, IHSLColor::class]),
        from: new ArrayObject(),
        converter: To\HSL\ToHSLConverter::class,
        instantiator: HSLInstantiator::class,
    ),
    new Wrapper(
        to: new ArrayObject([HSLA::class, IHSLAColor::class]),
        from: new ArrayObject(),
        converter: To\HSLA\ToHSLAConverter::class,
        instantiator: HSLAInstantiator::class,
    ),
);

$converters = [
    To\RGBA\ToRGBAConverter::class => [
        IRGBAColor::class => NoOpConverter::class,
        RGBA::class => NoOpConverter::class,
        IRGBColor::class => To\RGBA\From\FromRGBConverter::class,
        RGB::class => To\RGBA\From\FromRGBConverter::class,
        IHexColor::class => To\RGBA\From\FromRGBConverter::class,
        Hex::class => To\RGBA\From\FromRGBConverter::class,
        IHSLColor::class => To\RGBA\From\FromHSLConverter::class,
        HSL::class => To\RGBA\From\FromHSLConverter::class,
        IHSLAColor::class => To\RGBA\From\FromHSLConverter::class,
        HSLA::class => To\RGBA\From\FromHSLConverter::class,
    ],
    To\RGB\ToRGBConverter::class => [
        IRGBColor::class => NoOpConverter::class,
        RGB::class => NoOpConverter::class,
        IRGBAColor::class => To\RGB\From\FromRGBConverter::class,
        RGBA::class => To\RGB\From\FromRGBConverter::class,
        IHexColor::class => To\RGB\From\FromRGBConverter::class,
        Hex::class => To\RGB\From\FromRGBConverter::class,
        IHSLColor::class => To\RGB\From\FromHSLConverter::class,
        HSL::class => To\RGB\From\FromHSLConverter::class,
        IHSLAColor::class => To\RGB\From\FromHSLConverter::class,
        HSLA::class => To\RGB\From\FromHSLConverter::class,
    ],
    To\Hex\ToHexConverter::class => [
        IHexColor::class => NoOpConverter::class,
        Hex::class => NoOpConverter::class,
        IRGBAColor::class => To\Hex\From\FromRGBConverter::class,
        RGBA::class => To\Hex\From\FromRGBConverter::class,
        IRGBColor::class => To\Hex\From\FromRGBConverter::class,
        RGB::class => To\Hex\From\FromRGBConverter::class,
        IHSLColor::class => To\Hex\From\FromHSLConverter::class,
        HSL::class => To\Hex\From\FromHSLConverter::class,
        IHSLAColor::class => To\Hex\From\FromHSLConverter::class,
        HSLA::class => To\Hex\From\FromHSLConverter::class,
    ],
    To\HSLA\ToHSLAConverter::class => [
        IHSLAColor::class => NoOpConverter::class,
        HSLA::class => NoOpConverter::class,
        IHexColor::class => To\HSLA\From\FromRGBConverter::class,
        Hex::class => To\HSLA\From\FromRGBConverter::class,
        IRGBAColor::class => To\HSLA\From\FromRGBConverter::class,
        RGBA::class => To\HSLA\From\FromRGBConverter::class,
        IRGBColor::class => To\HSLA\From\FromRGBConverter::class,
        RGB::class => To\HSLA\From\FromRGBConverter::class,
        IHSLColor::class => To\HSLA\From\FromHSLConverter::class,
        HSL::class => To\HSLA\From\FromHSLConverter::class,
    ],
    To\HSL\ToHSLConverter::class => [
        IHSLColor::class => NoOpConverter::class,
        HSL::class => NoOpConverter::class,
        IHexColor::class => To\HSL\From\FromRGBConverter::class,
        Hex::class => To\HSL\From\FromRGBConverter::class,
        IRGBAColor::class => To\HSL\From\FromRGBConverter::class,
        RGBA::class => To\HSL\From\FromRGBConverter::class,
        IRGBColor::class => To\HSL\From\FromRGBConverter::class,
        RGB::class => To\HSL\From\FromRGBConverter::class,
        IHSLAColor::class => To\HSL\From\FromHSLConverter::class,
        HSLA::class => To\HSL\From\FromHSLConverter::class,
    ],

];
// idea:
//    new Wrapper(
//        to: new ArrayObject([RGBA::class, IRGBAColor::class]),
//        from: new ArrayObject([
//            IRGBAColor::class => NoOpConverter::class,  // # may be implied from to targets
//            RGBA::class => NoOpConverter::class,        // # may be implied from to targets
//            IRGBColor::class => FromRGBConverter::class,
//            RGB::class => FromRGBConverter::class,
//            IHexColor::class => FromRGBConverter::class,
//            Hex::class => FromRGBConverter::class,
//            IHSLColor::class => FromHSLConverter::class,
//            HSL::class => FromHSLConverter::class,
//            IHSLAColor::class => FromHSLConverter::class,
//            HSLA::class => FromHSLConverter::class,
//        ]),
//        converter: ToRGBAConverter::class,
//        instantiator: RGBAInstantiator::class,
//    ),


foreach ($converters as $toConverter => $fromConverters) {
    Registry::register($toConverter, new ArrayObject($fromConverters));
}
// @codeCoverageIgnoreEnd
