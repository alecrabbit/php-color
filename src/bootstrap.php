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
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Wrapper\Wrapper;

Package::add(
    new Wrapper(
        instantiator: HexInstantiator::class,
        converter: To\Hex\ToHexConverter::class,
        from: new ArrayObject([
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
        ]),
    ),
    new Wrapper(
        instantiator: RGBInstantiator::class,
        converter: To\RGB\ToRGBConverter::class,
        from: new ArrayObject([
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
        ]),
    ),
    new Wrapper(
        instantiator: RGBAInstantiator::class,
        converter: To\RGBA\ToRGBAConverter::class,
        from: new ArrayObject([
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
        ]),
    ),
    new Wrapper(
        instantiator: HSLInstantiator::class,
        converter: To\HSL\ToHSLConverter::class,
        from: new ArrayObject([
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
        ]),
    ),
    new Wrapper(
        instantiator: HSLAInstantiator::class,
        converter: To\HSLA\ToHSLAConverter::class,
        from: new ArrayObject([
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
        ]),
    ),
);
// @codeCoverageIgnoreEnd
