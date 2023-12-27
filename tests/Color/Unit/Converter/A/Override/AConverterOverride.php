<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\A\Override;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Converter\A\AToConverter;

class AConverterOverride extends AToConverter
{
    protected static function getTargetClass(): string
    {
        return '---dummy---';
    }

    public function convert(IConvertableColor $color): IConvertableColor
    {
        $this->unsupportedConversion($color);
    }
}
