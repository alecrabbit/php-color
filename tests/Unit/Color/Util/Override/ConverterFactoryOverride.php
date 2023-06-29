<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Util\Override;

use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IConverter;

final class ConverterFactoryOverride implements IConverterFactory
{

    public function make(string $class): IConverter
    {
        throw new \RuntimeException('INTENTIONALLY Not implemented.');
    }
}
