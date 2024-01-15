<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Store\Override;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\Store\IConverterStore;
use RuntimeException;

final class ConverterStoreOverride implements IConverterStore
{
    public static function register(string $class): void
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public function make(string $class): IToConverter
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    /**
     * @inheritDoc
     */
    public function getByTarget(string $class): IToConverter
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
