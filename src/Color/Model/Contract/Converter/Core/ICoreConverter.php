<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

use AlecRabbit\Color\Model\Contract\Converter\IColorDTOConverter;

interface ICoreConverter extends IColorDTOConverter
{
    final public const PRECISION = 6;
}
