<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Store\Override;

use AlecRabbit\Color\A\AColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;
use RuntimeException;

final class AColorOverride extends AColor
{
    protected static function colorModel(): IColorModel
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    protected static function fromDTO(DColor $dto): IColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public function toString(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    protected function toDTO(): DColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
