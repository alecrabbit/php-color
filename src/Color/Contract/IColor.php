<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;
use Stringable;

interface IColor extends IHasToString,
                         Stringable
{
    final public const CALC_PRECISION = ICoreConverter::CALC_PRECISION;
    final public const FLOAT_PRECISION = 3;

    public static function from(mixed $value): IColor;

    public function getColorModel(): IColorModel;

    /**
     * @template T of IColor|DColor
     *
     * @param class-string<T> $to
     *
     * @psalm-return T
     */
    public function to(string $to): IColor|DColor;
}
