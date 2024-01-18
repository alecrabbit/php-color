<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\A\Override;

use AlecRabbit\Color\A\AColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use RuntimeException;

final class AColorOverride extends AColor
{
    public function toString(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    protected function toDTO(): DColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
