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
    public static function fromDTO(DColor $dto): IColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public static function from(mixed $color): IColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public static function fromString(string $value): IColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    protected static function dtoType(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    protected static function createFromDTO(DColor $dto): IColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public function toString(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public function getColorModel(): IColorModel
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public function toDTO(): DColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
