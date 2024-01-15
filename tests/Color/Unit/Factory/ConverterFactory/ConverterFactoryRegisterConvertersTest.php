<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Factory\ConverterFactory;

use AlecRabbit\Color\Converter\To\ToRGBConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\Store\ConverterStore;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ConverterFactoryRegisterConvertersTest extends TestCase
{
    private array $registeredConverters;

    #[Test]
    public function convertersCanBeRegistered(): void
    {
        self::assertEmpty($this->getRegisteredConverters());
        ConverterStore::register(RGB::class, ToRGBConverter::class);

        $registeredConverters = $this->getRegisteredConverters();
        self::assertArrayHasKey(RGB::class, $registeredConverters);
        self::assertSame(ToRGBConverter::class, $registeredConverters[RGB::class]);
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
    public function throwsIfTargetClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);

        ConverterStore::register(stdClass::class, ToRGBConverter::class);
    }

    #[Test]
    public function throwsIfConverterClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);

        ConverterStore::register(RGB::class, stdClass::class);
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
