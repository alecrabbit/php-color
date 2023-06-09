<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Converter\ColorConverter;
use AlecRabbit\Color\Instantiator\ColorInstantiator;

AConvertableColor::useConverter(new ColorConverter());
AConvertableColor::useInstantiator(new ColorInstantiator());

// @codeCoverageIgnoreEnd
