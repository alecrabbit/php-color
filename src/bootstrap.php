<?php

declare(strict_types=1);


use AlecRabbit\Color\Converter\To;
use AlecRabbit\Color\Registry\Registry;

// @codeCoverageIgnoreStart

Registry::attach(
    To\ToHexConverter::class,
    To\ToHex8Converter::class,
    To\ToRGBConverter::class,
    To\ToRGBAConverter::class,
    To\ToHSLConverter::class,
    To\ToHSLAConverter::class,
);

// @codeCoverageIgnoreEnd
