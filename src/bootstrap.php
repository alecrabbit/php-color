<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\ColorInstantiator;
use AlecRabbit\Color\Converter\ColorConverter;

AConvertableColor::useConverter(new ColorConverter());
AConvertableColor::useInstantiator(new ColorInstantiator());

// @codeCoverageIgnoreEnd
