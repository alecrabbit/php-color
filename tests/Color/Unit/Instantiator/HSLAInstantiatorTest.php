<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Instantiator;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\HSLAInstantiator;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class HSLAInstantiatorTest extends TestCase
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
                new DRGB(0, 0, 0),
                UnsupportedValue::class,
                'Unsupported dto value of type "AlecRabbit\Color\Model\DTO\DRGB" provided.'
            ],
            ['hsl(22, 100%, 50%)', UnsupportedValue::class, 'Unsupported value of type "string" provided.'],
        ];
    }

    public static function canInstantiateDataProvider(): iterable
    {
        yield from [
            [new DHSL(0, 0, 0)],
        ];
    }

    public static function canIsSupportedDataProvider(): iterable
    {
        yield from [
            [new DHSL(0, 0, 0)],
        ];
    }

    public static function notIsSupportedDataProvider(): iterable
    {
        yield from [
            [new DRGB(0, 0, 0)],
            ['rgb(22, 22, 22)'],
            ['rgb(0, 0, 0)'],
            ['#ff0000'],
            ['ff0000'],
            ['#ff0'],
            ['ff0'],
            ['slaTeGray'],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $instantiator = $this->getTesteeInstance();

        self::assertInstanceOf(HSLAInstantiator::class, $instantiator);
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new HSLAInstantiator();
    }

    #[Test]
    #[DataProvider('canNotInstantiateDataProvider')]
    public function canNotInstantiate(mixed $value, string $exceptionClass, string $exceptionMessage): void
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $instantiator = $this->getTesteeInstance();

        $instantiator->from($value);
    }


    #[Test]
    #[DataProvider('canInstantiateDataProvider')]
    public function canInstantiate(mixed $value): void
    {
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->from($value);

        self::assertInstanceOf(HSLA::class, $color);
    }

    #[Test]
    #[DataProvider('canNotInstantiateDataProvider')]
    public function canNotInstantiateTryFrom(mixed $value): void
    {
        $instantiator = $this->getTesteeInstance();

        self::assertNull($instantiator->tryFrom($value));
    }

    #[Test]
    #[DataProvider('canIsSupportedDataProvider')]
    public function canIsSupported(mixed $value): void
    {
        self::assertTrue(HSLAInstantiator::isSupported($value));
    }

    #[Test]
    #[DataProvider('notIsSupportedDataProvider')]
    public function notIsSupported(mixed $value): void
    {
        self::assertFalse(HSLAInstantiator::isSupported($value));
    }
}
