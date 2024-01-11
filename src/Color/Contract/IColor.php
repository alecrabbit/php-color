<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use Stringable;

interface IColor extends IUnconvertibleColor, Stringable
{
    final public const CALC_PRECISION = ICoreConverter::PRECISION;
    final public const FLOAT_PRECISION = 3;

    public static function from(IColor $color): IColor;

    public static function fromDTO(IColorDTO $dto): IColor;

    /**
     * @param class-string<IColor> $class
     */
    public function to(string $class): IColor;

    public function toDTO(): IColorDTO;

    public function getColorModel(): IColorModel;
}
