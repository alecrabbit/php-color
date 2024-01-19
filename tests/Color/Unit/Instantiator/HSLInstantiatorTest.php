<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Instantiator;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class HSLInstantiatorTest extends TestCase
{
    public static function canInstantiateDataProvider(): iterable
    {
        yield from [
            [new DHSL(0, 0, 0)],
            ['hsl(22, 100%, 50%)'],
            ['hsl(64, 12%, 14%)'],
            ['hsl(0, 0%, 0%)'],
        ];
    }

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
            [
                'hsla(56, 100%, 50%, 1)',
                UnrecognizedColorString::class,
                'Unrecognized color string: "hsla(56, 100%, 50%, 1)".'
            ],
            [
                'hsla(56, 100%, 50%, 1)',
                UnrecognizedColorString::class,
                'Unrecognized color string: "hsla(56, 100%, 50%, 1)".'
            ],
            ['rgb(23, 0, 255)', UnrecognizedColorString::class, 'Unrecognized color string: "rgb(23, 0, 255)".'],
            ['slategray', UnrecognizedColorString::class, 'Unrecognized color string: "slategray".'],
            ['invalid', UnrecognizedColorString::class, 'Unrecognized color string: "invalid".'],
        ];
    }

    public static function canIsSupportedDataProvider(): iterable
    {
        yield from [
            [new DHSL(0, 0, 0)],
            ['hsl(22, 100%, 50%)'],
            ['hsl(64, 12%, 14%)'],
            ['hsl(0, 0%, 0%)'],
        ];
    }

    public static function notIsSupportedDataProvider(): iterable
    {
        yield from [
            [new DRGB(0, 0, 0)],
            ['hsla(56, 100%, 50%, 0)'],
            ['hsla(56, 100%, 50%, 1)'],
            ['hsla(56, 100%, 0%, 0)'],
            ['hsla(22, 0%, 0%, 0)'],
            ['hsla(33, 24%, 47%, 1)'],
            ['hsla(2, 79%, 47%, 0)'],
            ['rgba(255, 11, 255, 0)'],
            ['rgb(213, 30, 25)'],
            ['rgba(0, 0, 0, 0.5)'],
            ['rgb(13, 230, 125)'],
            ['slategray'],
            ['rgb(22, 22, 22)'],
            ['rgb(0, 0, 0)'],
            ['rgba(0, 2, 255, 1)'],
            ['rgba(255, 11, 255, 0.1)'],
            ['rgb(23, 0, 255)'],
            ['rgb(213, 30, 25)'],
            ['rgb(13, 230, 125)'],
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
    public function canBeCreated(): void
    {
        $instantiator = $this->getTesteeInstance();

        self::assertInstanceOf(HSLInstantiator::class, $instantiator);
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new HSLInstantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateDataProvider')]
    public function canInstantiate(mixed $value): void
    {
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->from($value);

        self::assertInstanceOf(HSL::class, $color);
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
    #[DataProvider('canIsSupportedDataProvider')]
    public function canIsSupported(mixed $value): void
    {
        self::assertTrue(HSLInstantiator::isSupported($value));
    }

    #[Test]
    #[DataProvider('notIsSupportedDataProvider')]
    public function notIsSupported(mixed $value): void
    {
        self::assertFalse(HSLInstantiator::isSupported($value));
    }
}
