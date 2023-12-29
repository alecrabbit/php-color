<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Instantiator;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class HSLInstantiatorTest extends TestCase
{
    public static function canInstantiateHSLDataProvider(): iterable
    {
        yield from [
            ['hsl(22, 100%, 50%)'],
            ['hsl(64, 12%, 14%)'],
            ['hsl(0, 0%, 0%)'],
        ];
    }

    public static function canNotInstantiateHSLADataProvider(): iterable
    {
        yield from [
            ['hsla(56, 100%, 50%, 1)'],
            ['hsla(56, 100%, 50%, 0)'],
            ['hsla(56, 100%, 0%, 0)'],
            ['hsla(22, 0%, 0%, 0)'],
            ['hsla(33, 24%, 47%, 1)'],
            ['hsla(2, 79%, 47%, 0)'],
        ];
    }

    public static function supportsFormatDataProvider(): iterable
    {
        yield from [
            ['hsl(22, 100%, 50%)'],
            ['hsl(64, 12%, 14%)'],
            ['hsl(0, 0%, 0%)'],
        ];
    }

    public static function doesNotSupportFormatDataProvider(): iterable
    {
        yield from [
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
    #[DataProvider('canInstantiateHSLDataProvider')]
    public function canInstantiateHSL(string $colorString): void
    {
        $instantiator = $this->getTesteeInstance();
        $color = $instantiator->fromString($colorString);
        self::assertInstanceOf(HSL::class, $color);
    }

    #[Test]
    #[DataProvider('canNotInstantiateHSLADataProvider')]
    public function canInstantiateHSLA(string $incoming): void
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

        self::fail(sprintf('Exception was not thrown. Color: "%s".', $incoming));
    }

    #[Test]
    #[DataProvider('supportsFormatDataProvider')]
    public function supportsFormat(string $format): void
    {
        self::assertTrue(HSLInstantiator::isSupported($format));
    }

    #[Test]
    #[DataProvider('doesNotSupportFormatDataProvider')]
    public function doesNotSupportFormat(string $format): void
    {
        self::assertFalse(HSLInstantiator::isSupported($format));
    }
}
