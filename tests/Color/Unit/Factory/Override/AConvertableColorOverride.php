<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Factory\Override;

use AlecRabbit\Color\A\AColor;
use AlecRabbit\Color\Contract\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use RuntimeException;

class AConvertableColorOverride extends AColor
{
    public function toString(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public function getColorModel(): IColorModel
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public function toDTO(): IColorDTO
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
