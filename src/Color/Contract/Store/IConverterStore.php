<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Store;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;

interface IConverterStore
{
    /**
     * @param class-string<IToConverter> $class
     */
    public static function register(string $class): void;

    /**
     * @deprecated Use {@see IConverterStore::getByTarget()} instead.
     *
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return IToConverter<T>
     */
    public function make(string $class): IToConverter;

    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return IToConverter<T>
     */
    public function getByTarget(string $class): IToConverter;
}
