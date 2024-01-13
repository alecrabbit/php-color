<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Instantiator;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;

/**
 * @template-covariant T of IColor
 */
interface IInstantiator
{
    public static function isSupported(string $color): bool;

    /**
     * @return class-string<IColor>
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
    public function fromDTO(IColorDTO $dto): IColor;
}
