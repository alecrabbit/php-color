<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Instantiator;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\Instantiator\Hex8Instantiator;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class Hex8InstantiatorTest extends TestCase
{
    public static function canInstantiateDataProvider(): iterable
    {
        yield from [
            [new DRGB(0, 0, 0)],
            ['#ff000000'],
            ['ff000000'],
            ['fF00A000'],
            ['#ff00'],
            ['ff00'],
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
                new DHSL(0, 0, 0),
                UnsupportedValue::class,
                'Unsupported dto value of type "AlecRabbit\Color\Model\DTO\DHSL" provided.'
            ],
            ['hsl(22, 100%, 50%)', UnrecognizedColorString::class, 'Unrecognized color string: "hsl(22, 100%, 50%)".'],
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
            [new DRGB(0, 0, 0)],
            ['#ff0000Aa'],
            ['ff000000'],
            ['#ff000000'],
            ['#ff0a'],
        ];
    }

    public static function notIsSupportedDataProvider(): iterable
    {
        yield from [
            [new DHSL(0, 0, 0)],
            ['slaTeGray'],
            ['slategray'],
            ['rgba(0, 0, 0, 0.5)'],
            ['LimeGreen'],
            ['slategray'],
            ['#ff0'],
            ['ff0'],
            ['rgba(0, 2, 255, 1)'],
            ['hsl(22, 100%, 50%)'],
            ['hsla(56, 100%, 50%, 1)'],
            ['rgb(23, 0, 255)'],
        ];
    }

    #[Test]
    public function canBeCreated(): void
    {
        $instantiator = $this->getTesteeInstance();

        self::assertInstanceOf(Hex8Instantiator::class, $instantiator);
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new Hex8Instantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateDataProvider')]
    public function canInstantiate(mixed $value): void
    {
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->from($value);

        self::assertInstanceOf(Hex8::class, $color);
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
        self::assertTrue(Hex8Instantiator::isSupported($value));
    }

    #[Test]
    #[DataProvider('notIsSupportedDataProvider')]
    public function notIsSupported(mixed $value): void
    {
        self::assertFalse(Hex8Instantiator::isSupported($value));
    }
}
