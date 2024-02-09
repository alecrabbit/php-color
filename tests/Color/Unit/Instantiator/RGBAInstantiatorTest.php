<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Instantiator;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Instantiator\RGBAInstantiator;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class RGBAInstantiatorTest extends TestCase
{
    public static function canNotInstantiateDataProvider(): iterable
    {
        yield from [
            [
                new stdClass(),
                UnsupportedValue::class,
                'Unsupported value of type "stdClass" provided.'
            ],
            [
                new DHSL(0, 0, 0),
                UnsupportedValue::class,
                'Unsupported dto value of type "AlecRabbit\Color\Model\DTO\DHSL" provided.'
            ],
            ['hsl(22, 100%, 50%)', UnsupportedValue::class, 'Unsupported value of type "string" provided.'],
            [
                'hsla(56, 100%, 50%, 1)',
                UnsupportedValue::class,
                'Unsupported value of type "string" provided.'
            ],
        ];
    }

    public static function canInstantiateDataProvider(): iterable
    {
        yield from [
            [new DRGB(0, 0, 0)],
        ];
    }

    public static function canIsSupportedDataProvider(): iterable
    {
        yield from [
            [new DRGB(0, 0, 0)],
        ];
    }

    public static function notIsSupportedDataProvider(): iterable
    {
        yield from [
            [new DHSL(0, 0, 0)],
            ['#ff0000'],
            ['rgb(23, 0, 255)'],
            ['hsl(22, 100%, 50%)'],
            ['hsla(56, 100%, 50%, 1)'],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $instantiator = $this->getTesteeInstance();

        self::assertInstanceOf(RGBAInstantiator::class, $instantiator);
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new RGBAInstantiator();
    }

    #[Test]
    #[DataProvider('canNotInstantiateDataProvider')]
    public function canNotInstantiateFrom(mixed $value, string $exceptionClass, string $exceptionMessage): void
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $instantiator = $this->getTesteeInstance();

        $instantiator->from($value);
    }

    #[Test]
    #[DataProvider('canNotInstantiateDataProvider')]
    public function canNotInstantiateTryFrom(mixed $value): void
    {
        $instantiator = $this->getTesteeInstance();

        self::assertNull($instantiator->tryFrom($value));
    }

    #[Test]
    #[DataProvider('canInstantiateDataProvider')]
    public function canInstantiate(mixed $value): void
    {
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->from($value);

        self::assertInstanceOf(RGBA::class, $color);
    }

    #[Test]
    #[DataProvider('canIsSupportedDataProvider')]
    public function canIsSupported(mixed $value): void
    {
        self::assertTrue(RGBAInstantiator::isSupported($value));
    }

    #[Test]
    #[DataProvider('notIsSupportedDataProvider')]
    public function notIsSupported(mixed $value): void
    {
        self::assertFalse(RGBAInstantiator::isSupported($value));
    }
}
