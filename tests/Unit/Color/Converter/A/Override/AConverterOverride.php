<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Converter\A\Override;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Converter\A\AConverter;

class AConverterOverride extends AConverter
{
    public function convert(IConvertableColor $color): IConvertableColor
    {
        $this->unsupportedConversion($color);
    }

    protected function getTargetClass(): string
    {
        return '---dummy---';
    }
}
