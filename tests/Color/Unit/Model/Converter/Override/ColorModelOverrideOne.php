<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Override;

use AlecRabbit\Color\Model\Contract\IColorModel;

final class ColorModelOverrideOne implements IColorModel
{
    public function dtoType(): string
    {
        throw new \RuntimeException(__METHOD__ . ' INTENTIONALLY Not implemented.');
    }
}
