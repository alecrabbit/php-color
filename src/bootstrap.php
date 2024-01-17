<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\Converter\To;
use AlecRabbit\Color\Registry\Registry;

Registry::attach(
    To\ToHexConverter::class,
    To\ToHex8Converter::class,
    To\ToRGBConverter::class,
    To\ToRGBAConverter::class,
    To\ToHSLConverter::class,
    To\ToHSLAConverter::class,
);
// @codeCoverageIgnoreEnd
