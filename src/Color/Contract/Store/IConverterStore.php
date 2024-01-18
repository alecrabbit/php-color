<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Store;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IConverterStore
{
    /**
     * @param class-string<IToConverter> $converterClass
     */
    public static function register(string $converterClass): void;

    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return IToConverter<T>
     */
    public function getByTarget(string $class): IToConverter;
}
