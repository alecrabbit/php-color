<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Instantiator;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBInstantiatorTest extends TestCase
{
    public static function canInstantiateRGBDataProvider(): iterable
    {
        yield from [
            ['rgb(23, 0, 255)'],
            ['rgb(213, 30, 25)'],
            ['rgb(13, 230, 125)'],
            ['rgb(22, 22, 22)'],
            ['rgb(0, 0, 0)'],
        ];
    }

    public static function canNotInstantiateRGBADataProvider(): iterable
    {
        yield from [
            ['rgba(0, 0, 0, 0.5)'],
            ['rgba(0, 2, 255, 1)'],
            ['rgba(255, 11, 255, 0)'],
            ['rgba(255, 11, 255, 0.1)'],
        ];
    }

    public static function supportsFormatDataProvider(): iterable
    {
        yield from [
            ['rgb(23, 0, 255)'],
            ['rgb(213, 30, 25)'],
            ['rgb(13, 230, 125)'],
            ['rgb(22, 22, 22)'],
            ['rgb(0, 0, 0)'],
        ];
    }

    public static function doesNotSupportFormatDataProvider(): iterable
    {
        yield from [
            ['#ff0000'],
            ['ff0000'],
            ['rgba(255, 11, 255, 0)'],
            ['#ff0'],
            ['rgba(0, 2, 255, 1)'],
            ['rgba(255, 11, 255, 0.1)'],
            ['ff0'],
            ['slategray'],
            ['rgba(0, 0, 0, 0.5)'],
            ['slaTeGray'],
            ['hsl(22, 100%, 50%)'],
            ['hsla(56, 100%, 50%, 1)'],
        ];
    }

    #[Test]
    public function canBeCreated(): void
    {
        $instantiator = $this->getTesteeInstance();

        self::assertInstanceOf(RGBInstantiator::class, $instantiator);
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new RGBInstantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateRGBDataProvider')]
    public function canInstantiateRGB(string $colorString): void
    {
        $instantiator = $this->getTesteeInstance();
        $color = $instantiator->fromString($colorString);
        self::assertInstanceOf(RGB::class, $color);
    }

    #[Test]
    #[DataProvider('canNotInstantiateRGBADataProvider')]
    public function canNotInstantiateRGBA(string $colorString): void
    {
        $this->expectException(UnrecognizedColorString::class);
        $this->expectExceptionMessage(
            sprintf(
                'Unrecognized color string: "%s".',
                $colorString
            )
        );

        $instantiator = $this->getTesteeInstance();
        $instantiator->fromString($colorString);

        self::fail(sprintf('Exception was not thrown. Color: "%s".', $colorString));
    }

    #[Test]
    #[DataProvider('supportsFormatDataProvider')]
    public function supportsFormat(string $format): void
    {
        self::assertTrue(RGBInstantiator::isSupported($format));
    }

    #[Test]
    #[DataProvider('doesNotSupportFormatDataProvider')]
    public function doesNotSupportFormat(string $format): void
    {
        self::assertFalse(RGBInstantiator::isSupported($format));
    }
    #[Test]
    public function canGetTargetClass(): void
    {
        self::assertSame(RGB::class, RGBInstantiator::getTargetClass());
    }

}
