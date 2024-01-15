<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @template-covariant T of IColor
 */
interface IInstantiator
{
    public static function isSupported(string $value): bool;

    /**
     * @return class-string<IColor>
     * @deprecated Changed visibility to protected. Do not use. No replacement.
     * // TODO 2024-01-15 17:49) [Alec Rabbit]:  remove from tests and interface
     *
     */
    public static function getTargetClass(): string;

    /**
     * @psalm-return T
     *
     * @throws UnrecognizedColorString
     */
    public function fromString(string $value): IColor;

    /**
     * @psalm-return T
     */
    public function from(DColor|string $value): IColor;
}
