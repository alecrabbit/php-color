<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Store\ConverterStore;

use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\To\ToRGBConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\Store\ConverterStore;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ConverterStoreRegisterConvertersTest extends TestCase
{
    private array $registeredConverters;

    #[Test]
    public function convertersCanBeRegistered(): void
    {
        self::assertEmpty($this->getRegisteredConverters());
        ConverterStore::register(ToRGBConverter::class);

        $registeredConverters = $this->getRegisteredConverters();
        self::assertArrayHasKey(RGB::class, $registeredConverters);
        self::assertArrayHasKey(IRGBColor::class, $registeredConverters);
        self::assertSame(ToRGBConverter::class, $registeredConverters[RGB::class]);
        self::assertSame(ToRGBConverter::class, $registeredConverters[IRGBColor::class]);
    }

    protected function getRegisteredConverters(): array
    {
        return self::getPropertyValue(ConverterStore::class, 'registered');
    }

    protected function setRegisteredConverters(array $registeredConverters): void
    {
        self::setPropertyValue(ConverterStore::class, 'registered', $registeredConverters);
    }

    #[Test]
    public function throwsIfConverterClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "stdClass" is not a "AlecRabbit\Color\Contract\Converter\IToConverter" subclass.');

        ConverterStore::register(stdClass::class);
    }

    protected function setUp(): void
    {
        $this->registeredConverters = $this->getRegisteredConverters();
        $this->setRegisteredConverters([]);
    }

    protected function tearDown(): void
    {
        $this->setRegisteredConverters($this->registeredConverters);
    }

}
