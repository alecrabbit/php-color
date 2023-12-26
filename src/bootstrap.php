<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\ToHex\ToHexConverter;
use AlecRabbit\Color\Converter\ToHSL\ToHSLAConverter;
use AlecRabbit\Color\Converter\ToHSL\ToHSLConverter;
use AlecRabbit\Color\Converter\ToRGB\ToRGBAConverter;
use AlecRabbit\Color\Converter\ToRGB\ToRGBConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\Package;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Wrapper;

Package::add(
    new Wrapper(
        targets: new \ArrayObject([Hex::class, IHexColor::class]),
        converter: ToHexConverter::class,
        instantiator: HexInstantiator::class,
    ),
    new Wrapper(
        targets: new \ArrayObject([RGB::class, IRGBColor::class]),
        converter: ToRGBConverter::class,
        instantiator: RGBInstantiator::class,
    ),
    new Wrapper(
        targets: new \ArrayObject([RGBA::class, IRGBAColor::class]),
        converter: ToRGBAConverter::class,
        instantiator: RGBInstantiator::class,
    ),
    new Wrapper(
        targets: new \ArrayObject([HSL::class, IHSLColor::class]),
        converter: ToHSLConverter::class,
        instantiator: HSLInstantiator::class,
    ),
    new Wrapper(
        targets: new \ArrayObject([HSLA::class, IHSLAColor::class]),
        converter: ToHSLAConverter::class,
        instantiator: HSLInstantiator::class,
    ),
);
// @codeCoverageIgnoreEnd
