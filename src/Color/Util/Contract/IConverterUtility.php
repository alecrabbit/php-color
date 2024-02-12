<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util\Contract;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IConverterUtility
{
    /**
     * @template T of IColor
     *
     * @param class-string<T> $target
     *
     * @psalm-return IToConverter<T>
     *
     * @throws ConverterUnavailable
     */
    public static function to(string $target): IToConverter;
}
