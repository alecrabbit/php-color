<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Util;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Tests\Color\Unit\Store\Override\ConverterStoreOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ColorSetConverterStoreClassMethodTest extends TestCase
{
    private const CONVERTER_STORE_CLASS = 'converterStoreClass';
    private string $converterStoreClass;

    #[Test]
    public function canSetFactoryClass(): void
    {
        $class = ConverterStoreOverride::class;

        Color::setConverterStoreClass($class);

        self::assertSame($class, self::getPropertyValue(Color::class, self::CONVERTER_STORE_CLASS));
    }

    #[Test]
    public function throwsIfClassIsNotSubclass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "stdClass" is not a "AlecRabbit\Color\Contract\Store\IConverterStore" subclass.'
        );
        Color::setConverterStoreClass(stdClass::class);
    }

    protected function setUp(): void
    {
        $this->converterStoreClass = self::getPropertyValue(Color::class, self::CONVERTER_STORE_CLASS);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Color::class, self::CONVERTER_STORE_CLASS, $this->converterStoreClass);
    }
}
