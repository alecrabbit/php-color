<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Util\Override;

use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IConverter;
use RuntimeException;

final class ConverterFactoryOverride implements IConverterFactory
{

    public static function registerConverter(string $targetClass, string $converterClass): void
    {
        // TODO: Implement registerConverter() method.
        throw new RuntimeException('Not implemented.');
    }

    public function make(string $class): IConverter
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
