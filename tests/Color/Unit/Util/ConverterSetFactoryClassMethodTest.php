<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Util;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Util\Converter;
use AlecRabbit\Tests\Color\Unit\Util\Override\ConverterStoreOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ConverterSetFactoryClassMethodTest extends TestCase
{
    private string $factoryClass;

    #[Test]
    public function canSetFactoryClass(): void
    {
        $class = ConverterStoreOverride::class;

        Converter::setFactoryClass($class);

        self::assertSame($class, self::getPropertyValue(Converter::class, 'factoryClass'));
    }

    #[Test]
    public function throwsIfClassIsNotSubclass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "stdClass" is not a "AlecRabbit\Color\Contract\Store\IConverterStore" subclass.'
        );
        Converter::setFactoryClass(stdClass::class);
    }

    protected function setUp(): void
    {
        $this->factoryClass = self::getPropertyValue(Converter::class, 'factoryClass');
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Converter::class, 'factoryClass', $this->factoryClass);
    }
}
