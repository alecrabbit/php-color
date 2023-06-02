<?php

declare(strict_types=1);

// @codeCoverageIgnoreStart

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\ColorConverter;
use AlecRabbit\Color\ColorInstantiator;

AConvertableColor::useConverter(new ColorConverter());
AConvertableColor::useInstantiator(new ColorInstantiator());

// @codeCoverageIgnoreEnd
