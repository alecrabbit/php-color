<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Converter\ColorConverter;
use AlecRabbit\Color\Instantiator;

AConvertableColor::useConverter(new ColorConverter());
AConvertableColor::useInstantiator(new Instantiator());

// @codeCoverageIgnoreEnd
