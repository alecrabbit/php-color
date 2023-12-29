<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Instantiator;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class HexInstantiatorTest extends TestCase
{
    public static function canInstantiateDataProvider(): iterable
    {
        yield from [
            ['#ff0000'],
            ['ff0000'],
            ['fF00A0'],
            ['#ff0'],
            ['ff0'],
            ['slategray'],
            ['slategray'],
        ];
    }

    public static function canNotInstantiateDataProvider(): iterable
    {
        yield from [
            ['invalid'],
        ];
    }

    public static function supportsFormatDataProvider(): iterable
    {
        yield from [
            ['slaTeGray'],
            ['ff0000'],
            ['ff0'],
            ['#ff0000'],
            ['LimeGreen'],
            ['slategray'],
            ['#ff0'],
        ];
    }

    public static function doesNotSupportFormatDataProvider(): iterable
    {
        yield from [
            ['rgba(0, 0, 0, 0.5)'],
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

        self::assertInstanceOf(HexInstantiator::class, $instantiator);
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new HexInstantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateDataProvider')]
    public function canInstantiate(string $colorString): void
    {
        $instantiator = $this->getTesteeInstance();
        $color = $instantiator->fromString($colorString);
        self::assertInstanceOf(Hex::class, $color);
    }

    #[Test]
    #[DataProvider('canNotInstantiateDataProvider')]
    public function canNotInstantiate(string $incoming): void
    {
        $this->expectException(UnrecognizedColorString::class);
        $this->expectExceptionMessage(
            sprintf(
                'Unrecognized color string: "%s".',
                $incoming
            )
        );
        $instantiator = $this->getTesteeInstance();

        $instantiator->fromString($incoming);
    }

    #[Test]
    #[DataProvider('supportsFormatDataProvider')]
    public function supportsFormat(string $format): void
    {
        self::assertTrue(HexInstantiator::isSupported($format));
    }

    #[Test]
    #[DataProvider('doesNotSupportFormatDataProvider')]
    public function doesNotSupportFormat(string $format): void
    {
        self::assertFalse(HexInstantiator::isSupported($format));
    }
}
