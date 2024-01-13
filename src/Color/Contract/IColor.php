<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;
use Stringable;

interface IColor extends IHasFromString,
                         IHasToString,
                         Stringable
{
    final public const CALC_PRECISION = ICoreConverter::PRECISION;
    final public const FLOAT_PRECISION = 3;

    public static function from(IColor $color): IColor;

    public static function fromString(string $value): IColor;

    public static function fromDTO(DColor $dto): IColor;

    public function getColorModel(): IColorModel;

    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return T
     */
    public function to(string $class): IColor;

    public function toDTO(): DColor;
}
