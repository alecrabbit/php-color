<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;

interface IInstantiator
{
    public static function isSupported(string $color): bool;

    /**
     * @return class-string<IColor>
     */
    public static function getTargetClass(): string;

    public function fromString(string $value): IColor;

    public function fromDTO(IColorDTO $dto): IColor;
}
