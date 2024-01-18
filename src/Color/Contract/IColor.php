<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Model\Contract\Converter\Core\IDCoreConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;
use Stringable;

interface IColor extends IHasToString,
                         Stringable
{
    final public const CALC_PRECISION = IDCoreConverter::CALC_PRECISION;
    final public const FLOAT_PRECISION = 3;

    public static function from(mixed $color): IColor;

    public function getColorModel(): IColorModel;

    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return T
     */
    public function to(string $class): IColor|DColor;

    public function toDTO(): DColor;
}
