<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @template-covariant T of IColor
 */
interface IInstantiator
{
    public static function isSupported(mixed $value): bool;

    /**
     * @psalm-return T
     *
     * @throws UnsupportedValue
     */
    public function from(DColor $value): IColor;

    /**
     * @psalm-return T
     */
    public function tryFrom(DColor $value): ?IColor;
}
