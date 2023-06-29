<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Util;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Util\Converter;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\Util\Override\ConverterFactoryOverride;
use PHPUnit\Framework\Attributes\Test;

class ConverterSetFactoryClassMethodTest extends TestCase
{
    private string $factoryClass;

    #[Test]
    public function canSetFactoryClass(): void
    {
        $class = ConverterFactoryOverride::class;

        Converter::setFactoryClass($class);

        self::assertSame($class, self::getPropertyValue(Converter::class, 'factoryClass'));
    }

    #[Test]
    public function throwsIfClassIsNotSubclass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "stdClass" is not a "AlecRabbit\Color\Contract\Factory\IConverterFactory" subclass.'
        );
        Converter::setFactoryClass(\stdClass::class);
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
