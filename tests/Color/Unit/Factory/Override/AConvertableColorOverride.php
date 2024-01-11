<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Factory\Override;

use AlecRabbit\Color\A\AColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use RuntimeException;

final class AConvertableColorOverride extends AColor
{
    public static function fromDTO(IColorDTO $dto): IColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public static function from(IColor $color): IColor
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public static function fromString(string $value): IColor
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

    public function toDTO(): IColorDTO
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }


}
