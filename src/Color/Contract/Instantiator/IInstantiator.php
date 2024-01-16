<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Exception\UnsupportedValue;

/**
 * @template-covariant T of IColor
 */
interface IInstantiator
{
    public static function isSupported(mixed $value): bool;

    /**
     * @return class-string<IColor>
     * @deprecated Changed visibility to protected. Do not use. No replacement.
     * // TODO 2024-01-15 17:49) [Alec Rabbit]:  remove from tests and interface
     *
     */
    public static function getTargetClass(): string;

    /**
     * @throws UnrecognizedColorString
     * @deprecated Changed visibility to protected. Use {@see IInstantiator::from()} instead.
     *
     * @psalm-return T
     *
     */
    public function fromString(string $value): IColor;

    /**
     * @psalm-return T
     *
     * @throws UnsupportedValue
     */
    public function from(mixed $value): IColor;

    /**
     * @psalm-return T
     */
    public function tryFrom(mixed $value): ?IColor;
}
